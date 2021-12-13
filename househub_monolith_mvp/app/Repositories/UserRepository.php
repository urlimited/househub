<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\DTO\UserModelDTO;
use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Entities\ContactInformationEntity;
use App\Repositories\Entities\UserEntity as UserEntity;
use App\Repositories\Entities\UserStatusHistoryEntity;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

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

    public function update(array|User $userData): User
    {
        if ($userData instanceof User)
            $userData = $this->userModelToArray($userData);

        $dataProcessed = $userData;

        $dataProcessed['user_id'] = $userData['id'];
        $dataProcessed['login'] = $userData['phone'];

        $statusEntity = UserStatusHistoryEntity::findByUserId($userData['id']);

        if ($statusEntity->statusId !== $userData['status_id'])
            UserStatusHistoryEntity::create(collect($dataProcessed)
                ->filter(function ($value, $key) {
                    return collect(['user_id', 'status_id'])->contains($key);
                })->toArray());

        // TODO: update contact information

        (UserEntity::findOrFail($dataProcessed['id']))
            ->fill($dataProcessed)
            ->save();

        return new User(
            id: $dataProcessed['id'],
            firstName: $dataProcessed['first_name'],
            lastName: $dataProcessed['last_name'],
            phone: $dataProcessed['phone'],
            roleId: $dataProcessed['role_id'],
            statusId: $dataProcessed['status_id']
        );
    }

    public function softDelete(): User
    {
        // TODO: Implement softDelete() method.

        return new User();
    }

    public function delete(): User
    {
        // TODO: Implement delete() method.

        return new User();
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

    #[ArrayShape([0 => "array", 'role' => "string", 'status' => "mixed"])]
    protected function userModelToArray(User $user): array
    {
        return [
            ...collect(get_object_vars($user))->reduce(function ($accum, $nextValue, $nextKey) {
                return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
            }, []),
        ];
    }
}
