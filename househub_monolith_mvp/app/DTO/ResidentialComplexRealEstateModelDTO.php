<?php

namespace App\DTO;

use App\Enums\RealEstateType;
use Exception;
use JetBrains\PhpStorm\Pure;

final class ResidentialComplexRealEstateModelDTO extends RealEstateModelDTO
{
    #[Pure]
    static public function repositoryCreateData(array $data): static
    {
        $realEstateData['address'] = $data['address'];
        $realEstateData['type_id'] = RealEstateType::residentialComplex;
        $realEstateData['city_id'] = $data['city_id'];

        $realEstateAttributes['name'] = $data['residential_complex_name'];

        return new ResidentialComplexRealEstateModelDTO(
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
            if($key == 'name') {
                $realEstateAttributes[$key] = $value;
            } else if (in_array($key, ['address', 'city_id'])) {
                $realEstateData[$key] = $value;
            }
        }

        return new ResidentialComplexRealEstateModelDTO(
            realEstateData: $realEstateData,
            realEstateAttributes: $realEstateAttributes
        );
    }
}
