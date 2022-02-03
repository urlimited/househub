<?php

namespace Database\Seeders;

use App\Enums\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'name' => 'Almaty',
                'country_id' => Country::Kazakhstan
            ],
            [
                'name' => 'Nur-Sultan',
                'country_id' => Country::Kazakhstan
            ]
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert($city);
        }
    }
}
