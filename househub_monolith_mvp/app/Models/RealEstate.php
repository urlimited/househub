<?php

namespace App\Models;

abstract class RealEstate
{
    public function __construct(
        public string $address,
        protected int $typeId,
        protected int $cityId,
        public ?int $id = null
    ){

    }

    abstract public function beforeCreate();
    abstract public function beforeDelete();
    abstract public function beforeUpdate();

    public function publish(){

    }
}
