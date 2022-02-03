<?php

namespace Tests\Feature\http\realEstate;

use App\Enums\RealEstateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateApartmentTest extends TestCase
{
    /**
     * @return void
     * @testdox Standard scenario for update apartment
     */
    public function testUpdateApartmentStandardScenario()
    {
        $data = [
            'address' => 'Satpaeva, 28B',
            'city_id' => 1,
            'house_id' => 625,
            'apartment_number' => '136A',
            'floor_number' => 2,
            'entrance' => '1 подъезд'
        ];

        $response = $this->json(method: 'post', uri: '/api/real-estates/apartments/628', data: $data);

        $response->assertStatus(200);

        $apartment = json_decode($response->getContent(), true)['data'];

        $response->assertJsonStructure([
            "data" => [
                "id",
                "address",
                "city_id",
                "apartment_number",
                "house_id",
                "floor_number",
                "entrance"
            ]
        ]);

        $this->assertDatabaseHas(table: 'real_estates', data: [
            'address' => $data['address'],
            'city_id' => $data['city_id'],
            'parent_id' => $data['house_id'],
            'type_id' => RealEstateType::apartment
        ]);

        $this->assertDatabaseHas(table: 'real_estate_attributes', data: [
            'key' => 'floor_number',
            'value' => $data['floor_number'],
            'real_estate_id' => $apartment['id']
        ]);

        $this->assertDatabaseHas(table: 'real_estate_attributes', data: [
            'key' => 'apartment_number',
            'value' => $data['apartment_number'],
            'real_estate_id' => $apartment['id']
        ]);

        $this->assertDatabaseHas(table: 'real_estate_attributes', data: [
            'key' => 'entrance',
            'value' => $data['entrance'],
            'real_estate_id' => $apartment['id']
        ]);
    }

}
