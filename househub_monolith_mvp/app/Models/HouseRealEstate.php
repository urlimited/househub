<?php

namespace App\Models;

final class HouseRealEstate extends RealEstate
{
    public function __construct(
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public string $houseNumber,
        public ?int $floorsTotalNumber = null,
        protected ?int $id = null
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
