<?php

namespace App\Models;

use JetBrains\PhpStorm\Pure;

final class HouseRealEstate extends RealEstate
{
    #[Pure]
    public function __construct(
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public string $houseNumber,
        public ?int $floorsTotalNumber = null,
        public ?int $residentialComplexId = null,
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
            'house_number' => $this->houseNumber,
            'floors_total_number' => $this->floorsTotalNumber
        ];
    }
}
