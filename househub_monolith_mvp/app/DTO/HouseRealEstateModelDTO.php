<?php

namespace App\DTO;

use App\Enums\RealEstateType;
use JetBrains\PhpStorm\Pure;

final class HouseRealEstateModelDTO extends RealEstateModelDTO
{
    #[Pure]
    static public function repositoryCreateData(array $data): static
    {
        $realEstateData = [
            'address' => $data['address'],
            'type_id' => RealEstateType::house,
            'city_id' => $data['city_id']
        ];

        if(key_exists('residential_complex_id', $data))
            $realEstateData['parent_id'] = $data['residential_complex_id'];

        $realEstateAttributes['number'] = $data['house_number'];

        if(key_exists('house_floors_total_number', $data))
            $realEstateAttributes['floors_total_number'] = $data['house_floors_total_number'];

        return new HouseRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }
}
