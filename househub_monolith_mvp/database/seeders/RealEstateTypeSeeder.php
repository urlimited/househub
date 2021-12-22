<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RealEstateTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'residential complex',
            'house',
            'apartment'
        ];

        foreach ($types as $type) {
            DB::table('real_estate_types')->insert([
                'name' => $type
            ]);
        }
    }
}
