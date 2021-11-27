<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'blocked'
        ];

        foreach ($statuses as $status) {
            DB::table('user_statuses')->insert([
                'name' => $status
            ]);
        }
    }
}
