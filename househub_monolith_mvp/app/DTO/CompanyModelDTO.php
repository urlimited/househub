<?php

namespace App\DTO;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

abstract class CompanyModelDTO extends BaseModelDTO
{
    public function __construct(
        #[ArrayShape([
            'id' => 'int',
            'type_id' => 'int',
            'address' => 'string',
            'city_id' => 'int',
            'parent_id' => 'int'
        ])]
        public array $companyEntityData,
        public array $companyStatusHistory
    )
    {

    }

    #[Pure]
    abstract static public function repositoryCreateData(array $data): static;
    abstract static public function repositoryUpdateData(array $data): static;
}
