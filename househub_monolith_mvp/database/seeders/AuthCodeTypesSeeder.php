<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AuthCodeTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'phone',
            'email'
        ];

        foreach ($types as $type) {
            DB::table('auth_code_types')->insert([
                'name' => $type
            ]);
        }
    }
}
