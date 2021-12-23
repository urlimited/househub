<?php

namespace App\DTO;

use JetBrains\PhpStorm\Pure;

abstract class RealEstateModelDTO extends BaseModelDTO
{
    public function __construct(
        public array $realEstateData,
        public array $realEstateAttributes
    )
    {

    }

    #[Pure]
    abstract static public function repositoryCreateData(array $data): static;
}
