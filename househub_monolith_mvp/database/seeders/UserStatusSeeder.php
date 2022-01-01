<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'registered',
            'approved',
            'blocked',
            'phone confirmed',
            'deleted'
        ];

        foreach ($statuses as $status) {
            DB::table('user_statuses')->insert([
                'name' => $status
            ]);
        }
    }
}
