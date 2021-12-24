<?php

namespace Database\Seeders\testing;

use App\Enums\RealEstateType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingRealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realEstates = [
            [
                'data' => [
                    'address' => 'Timiryazeva, 28B',
                    'city_id' => 1,
                    'type_id' => RealEstateType::house,
                ],
                'attributes' => [
                    'number' => '133/2'
                ]
            ],
            [
                'data' => [
                    'address' => 'Tlendiyeva, 223',
                    'city_id' => 1,
                    'type_id' => RealEstateType::house,
                    'parent_id' => 392
                ],
                'attributes' => [
                    'number' => '223',
                    'floors_total_number' => 22,
                ]
            ],
            [
                'data' => [
                    'address' => 'Tlendiyeva, 223',
                    'city_id' => 1,
                    'type_id' => RealEstateType::apartment,
                    'parent_id' => 625
                ],
                'attributes' => [
                    'number' => '135',
                    'floor_number' => 21,
                    'entrance' => '1 подъезд'
                ]
            ]
        ];

        foreach ($realEstates as $realEstate) {
            $realEstateId = DB::table('real_estates')->insertGetId($realEstate['data']);

            foreach($realEstate['attributes'] as $key => $attr){
                DB::table('real_estate_attributes')->insert([
                    'key' => $key,
                    'value' => $attr,
                    'real_estate_id' => $realEstateId
                ]);
            }
        }
    }
}
