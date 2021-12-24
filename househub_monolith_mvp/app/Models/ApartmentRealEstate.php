<?php

namespace App\Models;

final class ApartmentRealEstate extends RealEstate
{
    public function __construct(
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public string $apartmentNumber,
        public int $houseId,
        public ?string $floorNumber = null,
        public ?string $entrance = null,
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

    public function publish()
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city_id' => $this->cityId,
            'apartment_number' => $this->apartmentNumber,
            'house_id' => $this->houseId,
            'floor_number' => $this->floorNumber,
            'entrance' => $this->entrance
        ];
    }
}
