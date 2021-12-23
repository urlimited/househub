<?php

namespace App\Contracts\Repositories;

use App\DTO\RealEstateModelDTO;
use App\Models\RealEstate;

interface RealEstateRepositoryContract
{
    public function create(RealEstateModelDTO $realEstateData): RealEstate;
    public function update(RealEstateModelDTO $realEstateData): RealEstate;
    public function softDelete(): RealEstate;
    public function delete(): RealEstate;
    public function find(int $id): RealEstate;
}
