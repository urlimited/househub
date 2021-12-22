<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'Kazakhstan'
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country
            ]);
        }
    }
}
