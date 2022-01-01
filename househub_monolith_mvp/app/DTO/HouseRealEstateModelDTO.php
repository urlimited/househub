<?php

namespace App\DTO;

use App\Enums\RealEstateType;
use Exception;
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

        $realEstateAttributes['house_number'] = $data['house_number'];

        if(key_exists('house_floors_total_number', $data))
            $realEstateAttributes['floors_total_number'] = $data['house_floors_total_number'];

        return new HouseRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }

    /**
     * @throws Exception
     */
    static public function repositoryUpdateData(array $data): static
    {
        if(!key_exists('id', $data))
            throw new Exception('id is not presented in Data array for repositoryUpdateData method');

        $realEstateData = [
            'id' => $data['id']
        ];

        $realEstateAttributes = [];

        foreach($data as $key => $value){
            if($key == 'house_number') {
                $realEstateAttributes[$key] = $value;
            } else if (in_array($key, ['address', 'city_id'])) {
                $realEstateData[$key] = $value;
            } else {
                if($key === 'residential_complex_id')
                    $realEstateData['parent_id'] = $value;

                if($key === 'house_floors_total_number')
                    $realEstateAttributes['floors_total_number'] = $value;
            }
        }

        return new HouseRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }
}
