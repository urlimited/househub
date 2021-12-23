<?php

namespace App\Models;

use JetBrains\PhpStorm\Pure;

final class ResidentialComplexRealEstate extends RealEstate
{
    #[Pure]
    public function __construct(
        public string $name,
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public ?int $id = null
    ){
        parent::__construct(
            address: $address,
            typeId: $typeId,
            cityId: $cityId,
            id: $id
        );
    }

    public function beforeCreate()
    {
        // TODO: Implement beforeCreate() method.
    }

    public function beforeDelete()
    {
        // TODO: Implement beforeDelete() method.
    }

    public function beforeUpdate()
    {
        // TODO: Implement beforeUpdate() method.
    }
}
