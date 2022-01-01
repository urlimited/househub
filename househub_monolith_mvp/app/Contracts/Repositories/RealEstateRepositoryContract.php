<?php

namespace App\Contracts\Repositories;

use App\DTO\RealEstateModelDTO;
use App\Models\RealEstate;

interface RealEstateRepositoryContract
{
    public function create(RealEstateModelDTO $realEstateData): RealEstate;
    public function update(RealEstateModelDTO $realEstateData): RealEstate;
    public function softDelete(int $id): RealEstate;
    public function delete(int $id): RealEstate;
    public function find(int $id): RealEstate;
}
