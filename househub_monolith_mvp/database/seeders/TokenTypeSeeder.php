<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'access',
            'refresh',
        ];

        foreach ($types as $type) {
            DB::table('token_types')->insert([
                'name' => $type
            ]);
        }
    }
}
