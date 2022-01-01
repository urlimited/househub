<?php

namespace App\DTO;

use App\Enums\RealEstateType;
use Exception;
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
            if(in_array($key, ['apartment_number', 'floor_number', 'entrance'])) {
                $realEstateAttributes[$key] = $value;
            } else if (in_array($key, ['address', 'city_id'])) {
                $realEstateData[$key] = $value;
            } else {
                if($key === 'house_id')
                    $realEstateData['parent_id'] = $value;
            }
        }

        return new ApartmentRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }
}
