<?php

namespace Database\Seeders\testing;

use App\Enums\AuthCodeType;
use App\Enums\ContactInformationType;
use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'login' => '+77771557027',
                'first_name' => 'Edie',
                'last_name' => 'Broke',
                'role_id' => Role::resident,
            ]
        ];

        foreach ($users as $userData) {
            $userId = DB::table('users')->insertGetId($userData);
            DB::table('user_status_histories')->insert([
                'user_id' => $userId,
                'status_id' => UserStatus::registered
            ]);
            DB::table('contact_information')->insert([
                'user_id' => $userId,
                'type_id' => ContactInformationType::phone,
                'value' => $userData['login']
            ]);

            DB::table('auth_codes')->insert([
                'type_id' => AuthCodeType::phone,
                'user_id' => $userId,
                'code' => '1111',
                'notificator_id' => 1
            ]);
        }
    }
}
