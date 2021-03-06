<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryContract;
use App\DTO\UserModelDTO;
use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Entities\ContactInformationEntity;
use App\Repositories\Entities\UserEntity as UserEntity;
use App\Repositories\Entities\UserStatusHistoryEntity;

final class UserRepository implements UserRepositoryContract
{

    public function create(UserModelDTO $userData): User
    {
        $userId = UserEntity::create($userData->userEntityData)->id;

        UserStatusHistoryEntity::create([
            'user_id' => $userId,
            'status_id' => UserStatus::registered
        ]);

        foreach ($userData->contactInformationEntityData as $info) {
            ContactInformationEntity::create([...$info, 'user_id' => $userId]);
        }

        return new User(
            id: $userId,
            firstName: $userData->userEntityData['first_name'],
            lastName: $userData->userEntityData['last_name'],
            phone: $userData->userEntityData['login'],
            roleId: $userData->userEntityData['role_id'],
            statusId: $userData->userEntityData['status_id']
        );
    }

    public function update(UserModelDTO $userData): User
    {
        $statusEntity = UserStatusHistoryEntity::findByUserId($userData->userEntityData['id']);

        if ($statusEntity->statusId !== $userData->statusEntityData['status_id'])
            UserStatusHistoryEntity::create([
                ...$userData->statusEntityData,
                'user_id' => $userData->userEntityData['id']
            ]);

        foreach ($userData->contactInformationEntityData as $info) {
            ContactInformationEntity::updateOrCreate(
                [
                    'type_id' => $info['type_id'], 'user_id' => $userData->userEntityData['id']
                ], $info);
        }

        $updatedUser = (UserEntity::findOrFail($userData->userEntityData['id']))
            ->fill($userData->userEntityData);

        $updatedUser->save();

        return new User(
            id: $updatedUser->id,
            firstName: $updatedUser->firstName,
            lastName: $updatedUser->lastName,
            phone: $updatedUser->login,
            roleId: $updatedUser->roleId,
            statusId: $userData->statusEntityData['status_id']
        );
    }

    public function softDelete(int $id): User
    {
        UserStatusHistoryEntity::create([
            'status_id' => UserStatus::deleted,
            'user_id' => $id
        ]);

        $userEntity = UserEntity::findOrFail($id);

        return new User(
            id: $id,
            firstName: $userEntity->firstName,
            lastName: $userEntity->lastName,
            phone: $userEntity->login,
            roleId: $userEntity->roleId,
            statusId: UserStatus::deleted
        );
    }

    public function delete(int $id): User
    {
        $userEntity = UserEntity::findOrFail($id);

        $userEntity->delete();

        return new User(
            id: $id,
            firstName: $userEntity->firstName,
            lastName: $userEntity->lastName,
            phone: $userEntity->login,
            roleId: $userEntity->roleId,
            statusId: UserStatus::deleted
        );
    }

    public function find(int $id): User
    {
        $userData = UserEntity::findOrFail($id)->toArray();

        $statusData = UserStatusHistoryEntity::findByUserId($id);

        return new User(
            id: $userData['id'],
            firstName: $userData['first_name'],
            lastName: $userData['last_name'],
            phone: $userData['login'],
            roleId: $userData['role_id'],
            statusId: $statusData->id
        );
    }

    public function findByLogin(string $login): User
    {
        $userData = UserEntity::where('login', $login)->firstOrFail()->toArray();

        $statusData = UserStatusHistoryEntity::findByUserId($userData['id']);

        return new User(
            id: $userData['id'],
            firstName: $userData['first_name'],
            lastName: $userData['last_name'],
            phone: $userData['login'],
            roleId: $userData['role_id'],
            statusId: $statusData->id
        );
    }
}
