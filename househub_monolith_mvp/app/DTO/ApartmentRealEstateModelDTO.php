<?php

namespace App\DTO;

use App\Enums\RealEstateType;
use JetBrains\PhpStorm\Pure;

final class ApartmentRealEstateModelDTO extends RealEstateModelDTO
{
    #[Pure]
    static public function repositoryCreateData(array $data): static
    {
        $realEstateData = [
            'address' => $data['address'],
            'type_id' => RealEstateType::apartment,
            'city_id' => $data['city_id'],
            'parent_id' => $data['house_id']
        ];

        $realEstateAttributes = [
            'apartment_number' => $data['apartment_number']
        ];

        if(key_exists('floor_number', $data))
            $realEstateAttributes['floor_number'] = $data['floor_number'];

        if(key_exists('entrance', $data))
            $realEstateAttributes['entrance'] = $data['entrance'];

        return new ApartmentRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }
}
