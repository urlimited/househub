<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Models\User;
use App\Repositories\Entities\ContactInformationEntity;
use App\Repositories\Entities\UserEntity as UserEntity;
use App\Repositories\Entities\UserStatusHistoryEntity;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

final class UserRepository implements UserRepositoryContract
{

    public function create(array|User $userData): User
    {
        if($userData instanceof User)
            $userData = $this->userModelToArray($userData);

        $dataProcessed = collect($userData)->reduce(function ($accum, $nextValue, $nextKey) {
            return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
        }, []);

        $dataProcessed['user_id'] = UserEntity::create($dataProcessed)->id;

        UserStatusHistoryEntity::create($dataProcessed);

        foreach ($dataProcessed['contact_information'] as $info) {
            ContactInformationEntity::create([...$info, 'user_id' => $dataProcessed['user_id']]);
        }

        $dataProcessed['id'] = $dataProcessed['user_id'];

        return new User($dataProcessed);
    }

    public function update(array|User $userData): User
    {
        if($userData instanceof User)
            $userData = $this->userModelToArray($userData);

        $dataProcessed = $userData;

        $dataProcessed['user_id'] = $userData['id'];
        $dataProcessed['login'] = $userData['phone'];

        $statusEntity = UserStatusHistoryEntity::findByUserId($userData['id']);

        if($statusEntity->statusId !== $userData['status_id'])
            UserStatusHistoryEntity ::create(collect($dataProcessed)
                ->filter(function($value, $key){
                    return collect(['user_id', 'status_id'])->contains($key);
                })->toArray());

        // TODO: update contact information

        (UserEntity::findOrFail($dataProcessed['id']))
            ->fill($dataProcessed)
            ->save();

        return new User($dataProcessed);
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

        return new User([
            ...$userData,
            'phone' => $userData['login'],
            'status_id' => $statusData->id
        ]);
    }

    public function findByLogin(string $login): User
    {
        $userData = UserEntity::where('login', $login)->firstOrFail()->toArray();

        $statusData = UserStatusHistoryEntity::findByUserId($userData['id']);

        return new User([
            ...$userData,
            'phone' => $userData['login'],
            'status_id' => $statusData->id
        ]);
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
