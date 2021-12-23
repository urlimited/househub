<?php

namespace App\Repositories;

use App\Contracts\Repositories\RealEstateRepositoryContract;
use App\DTO\RealEstateModelDTO;
use App\Enums\RealEstateType;
use App\Models\ApartmentRealEstate;
use App\Models\HouseRealEstate;
use App\Models\RealEstate;
use App\Models\ResidentialComplexRealEstate;
use App\Repositories\Entities\RealEstateAttributeEntity;
use App\Repositories\Entities\RealEstateEntity;
use Illuminate\Support\Str;

final class RealEstateRepository implements RealEstateRepositoryContract
{

    public function create(RealEstateModelDTO $realEstateData): RealEstate
    {
        $realEstate = RealEstateEntity::create($realEstateData->realEstateData);

        foreach ($realEstateData->realEstateAttributes as $key => $attribute) {
            RealEstateAttributeEntity::create([
                'key' => $key,
                'value' => $attribute,
                'real_estate_id' => $realEstate->id
            ]);
        }

        return match ($realEstate->typeId) {
            RealEstateType::residentialComplex => new ResidentialComplexRealEstate(
                ...[
                    ...collect($realEstateData->realEstateAttributes)
                        ->reduce(function ($accum, $nextValue, $nextKey) {
                            return [...$accum, Str::camel($nextKey) => $nextValue];
                        }, []),
                    'address' => $realEstate->address,
                    'typeId' => $realEstate->typeId,
                    'cityId' => $realEstate->cityId,
                    'id' => $realEstate->id
                ]
            ),
            RealEstateType::house => new HouseRealEstate(
                ...[
                    ...collect($realEstateData->realEstateAttributes)
                        ->reduce(function ($accum, $nextValue, $nextKey) {
                            return [...$accum, Str::camel($nextKey) => $nextValue];
                        }, []),
                    'address' => $realEstate->address,
                    'typeId' => $realEstate->typeId,
                    'cityId' => $realEstate->cityId,
                    'id' => $realEstate->id
                ]
            ),
            RealEstateType::apartment => new ApartmentRealEstate(
                ...[
                    ...collect($realEstateData->realEstateAttributes)
                        ->reduce(function ($accum, $nextValue, $nextKey) {
                            return [...$accum, Str::camel($nextKey) => $nextValue];
                        }, []),
                    'address' => $realEstate->address,
                    'typeId' => $realEstate->typeId,
                    'cityId' => $realEstate->cityId,
                    'id' => $realEstate->id
                ]
            ),
            default => null,
        };
    }

    public function update(RealEstateModelDTO $realEstateData): RealEstate
    {
        return new HouseRealEstate();
    }

    public function softDelete(): RealEstate
    {
        // TODO: Implement softDelete() method.

        return new HouseRealEstate();
    }

    public function delete(): RealEstate
    {
        // TODO: Implement delete() method.

        return new HouseRealEstate();
    }

    public function find(int $id): RealEstate
    {
        return new HouseRealEstate();
    }
}
