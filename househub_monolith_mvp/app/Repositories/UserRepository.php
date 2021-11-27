<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    public function create(array $data): User
    {
        $usersTableData = collect($data)
            ->filter(function($value, $key){
                return in_array($key, [
                    'first_name',
                    'last_name',
                    'login',
                    'password',
                    'role_id'
                ]);
            })->toArray();

        $statusHistoryTableData = collect($data)
            ->filter(function($value, $key){
                return $key == 'status';
            })->toArray();

        $contactInformationTableData = collect($data)
            ->filter(function(){
                return in_array($key, );
            })->toArray();

        DB::table('users')->insert($usersTableData);

        DB::table('user_status_histories')->insert($statusHistoryTableData);

        return new User($data);
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function softDelete()
    {
        // TODO: Implement softDelete() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function find()
    {
        // TODO: Implement find() method.
    }
}
