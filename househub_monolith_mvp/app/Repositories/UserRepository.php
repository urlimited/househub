<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryContract;
use App\Models\User;
use App\Repositories\Entities\BaseModel;
use App\Repositories\Entities\ContactInformationEntity;
use App\Repositories\Entities\UserEntity as UserEntity;
use App\Repositories\Entities\UserStatusHistoryEntity;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryContract
{

    public function create(array $data): User
    {
        $dataProcessed = collect($data)->reduce(function($accum, $nextValue, $nextKey){
            return array_merge($accum, [Str::snake($nextKey) => $nextValue]);
        }, []);

        $dataProcessed['user_id'] = UserEntity::create($dataProcessed)->id;

        UserStatusHistoryEntity::create($dataProcessed);
        foreach($dataProcessed['contact_information'] as $info) {
            ContactInformationEntity::create([...$info, 'user_id' => $dataProcessed['user_id']]);
        }

        $dataProcessed['id'] = $dataProcessed['user_id'];

        return new User($dataProcessed);
    }

    public function update(): User
    {
        // TODO: Implement update() method.

        return new User();
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

    public function findByLogin(string $login): User {
        $userData = UserEntity::where('login', $login)->firstOrFail()->toArray();

        $statusData = UserStatusHistoryEntity::findByUserId($userData['id']);

        return new User([
            ...$userData,
            'phone' => $userData['login'],
            'status_id' => $statusData->id
        ]);
    }
}
