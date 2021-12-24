<?php

namespace Database\Seeders;

use Database\Seeders\testing\TestingRealEstateSeeder;
use Database\Seeders\testing\TestingUserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $seeders = [
            UserStatusSeeder::class,
            RoleSeeder::class,
            ContactInformationTypeSeeder::class,
            AuthCodeTypesSeeder::class,
            NotificatorTypeSeeder::class,
            NotificatorSeeder::class,
            TokenTypeSeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            RealEstateTypeSeeder::class,
            ResidentialComplexRealEstateSeeder::class
        ];

        if(App::environment('testing')){
            $seeders[] = TestingRealEstateSeeder::class;
            $seeders[] = TestingUserSeeder::class;
        }

        $this->call($seeders);
    }
}
