<?php

namespace App\DTO;

use App\Enums\RealEstateType;
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
}
