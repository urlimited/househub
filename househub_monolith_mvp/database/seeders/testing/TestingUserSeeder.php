<?php

namespace Database\Seeders\testing;

use App\Enums\AuthCodeType;
use App\Enums\ContactInformationType;
use App\Enums\NotificatorType;
use App\Enums\RealEstateType;
use App\Enums\Role;
use App\Enums\UserStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

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
                'id' => Uuid::fromString(Str::orderedUuid())->getBytes(),
                'login' => '+77771557027',
                'first_name' => 'Edie',
                'last_name' => 'Broke',
                'role_id' => Role::resident,
            ]
        ];

        $notificatorId = DB::table('notificators')
            ->select(DB::raw('BIN_TO_UUID(id) as id'))
            ->where('type_id', NotificatorType::call)
            ->first()
            ->id;

        foreach ($users as $userData) {
            DB::table('users')->insert($userData);
            DB::table('user_status_histories')->insert([
                'user_id' => $userData['id'],
                'status_id' => UserStatus::registered
            ]);
            DB::table('contact_information')->insert([
                'user_id' => $userData['id'],
                'type_id' => ContactInformationType::phone,
                'value' => $userData['login']
            ]);

            DB::table('auth_codes')->insert([
                'type_id' => AuthCodeType::phone,
                'user_id' => $userData['id'],
                'code' => '1111',
                'notificator_id' => Uuid::fromString($notificatorId)->getBytes()
            ]);
        }
    }
}
