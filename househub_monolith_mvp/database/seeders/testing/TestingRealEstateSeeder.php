<?php

namespace Database\Seeders\testing;

use App\Enums\RealEstateType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class TestingRealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $realEstateId = DB::table('real_estates')
            ->select(DB::raw('BIN_TO_UUID(id) as id'))
            ->where('type_id', RealEstateType::residentialComplex)
            ->offset(392)
            ->first()
            ->id;

        $houseId = Uuid::fromString(Str::orderedUuid())->getBytes();

        $realEstates = [
            [
                'data' => [
                    'id' => Uuid::fromString(Str::orderedUuid())->getBytes(),
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
                    'id' => $houseId,
                    'address' => 'Tlendiyeva, 223',
                    'city_id' => 1,
                    'type_id' => RealEstateType::house,
                    'parent_id' => Uuid::fromString($realEstateId)->getBytes()
                ],
                'attributes' => [
                    'number' => '223',
                    'floors_total_number' => 22,
                ]
            ],
            [
                'data' => [
                    'id' => Uuid::fromString(Str::orderedUuid())->getBytes(),
                    'address' => 'Tlendiyeva, 223',
                    'city_id' => 1,
                    'type_id' => RealEstateType::apartment,
                    'parent_id' => $houseId
                ],
                'attributes' => [
                    'number' => '135',
                    'floor_number' => 21,
                    'entrance' => '1 подъезд'
                ]
            ]
        ];

        foreach ($realEstates as $realEstate) {
            DB::table('real_estates')
                ->insert($realEstate['data']);

            foreach($realEstate['attributes'] as $key => $attr){
                DB::table('real_estate_attributes')->insert([
                    'key' => $key,
                    'value' => $attr,
                    'real_estate_id' => $realEstate['data']['id']
                ]);
            }
        }
    }
}
