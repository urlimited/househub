<?php

namespace App\Models;

final class ApartmentRealEstate extends RealEstate
{
    public function __construct(
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public string $apartmentNumber,
        public ?string $floorNumber = null,
        public ?string $entrance = null,
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
