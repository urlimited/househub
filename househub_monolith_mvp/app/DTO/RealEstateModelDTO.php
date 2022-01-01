<?php

namespace App\DTO;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class RealEstateModelDTO extends BaseModelDTO
{
    public function __construct(
        #[ArrayShape([
            'id' => 'int',
            'type_id' => 'int',
            'address' => 'string',
            'city_id' => 'int',
            'parent_id' => 'int'
        ])]
        public array $realEstateData,
        public array $realEstateAttributes
    )
    {

    }

    #[Pure]
    abstract static public function repositoryCreateData(array $data): static;
}
