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

        return $this->identifyRealEstate(
            realEstateAttributes: $realEstateData->realEstateAttributes,
            realEstate: $realEstate
        );
    }

    public function update(RealEstateModelDTO $realEstateData): RealEstate
    {
        $realEstate = RealEstateEntity::findOrFail($realEstateData->realEstateData['id']);

        RealEstateEntity::update($realEstateData->realEstateData);

        foreach ($realEstateData->realEstateAttributes as $key => $attribute) {
            RealEstateAttributeEntity::updateOrCreate([
                'real_estate_id' => $realEstate->id,
                'key' => $key
            ], ['value' => $attribute]);
        }

        return $this->identifyRealEstate(
            realEstateAttributes: $realEstateData->realEstateAttributes,
            realEstate: $realEstate
        );
    }

    public function softDelete(int $id): RealEstate
    {
        $realEstate = RealEstateEntity::findOrFail($id);

        $realEstateAttributes = RealEstateAttributeEntity::where(['real_estate_id' => $id])
            ->get()->reduce(
                function (array $accum, $realEstateAttribute) {
                    return [...$accum, $realEstateAttribute->key => $realEstateAttribute->value];
                }, []);

        $realEstate->update(['deleted_at' => now()]);

        return $this->identifyRealEstate(
            realEstateAttributes: $realEstateAttributes,
            realEstate: $realEstate
        );
    }

    public function delete(int $id): RealEstate
    {
        $realEstate = RealEstateEntity::findOrFail($id);

        $realEstateAttributes = RealEstateAttributeEntity::where(['real_estate_id' => $id])
            ->get()->reduce(
                function (array $accum, $realEstateAttribute) {
                    return [...$accum, $realEstateAttribute->key => $realEstateAttribute->value];
                }, []);

        $realEstate->delete();

        return $this->identifyRealEstate(
            realEstateAttributes: $realEstateAttributes,
            realEstate: $realEstate
        );
    }

    public function find(int $id): RealEstate
    {
        $realEstate = RealEstateEntity::findOrFail($id);

        $realEstateAttributes = RealEstateAttributeEntity::where(['real_estate_id' => $id])
            ->get()->reduce(
                function (array $accum, $realEstateAttribute) {
                    return [...$accum, $realEstateAttribute->key => $realEstateAttribute->value];
                }, []);

        return $this->identifyRealEstate(
            realEstateAttributes: $realEstateAttributes,
            realEstate: $realEstate
        );
    }

    private function identifyRealEstate(
        array            $realEstateAttributes,
        RealEstateEntity $realEstate
    ): RealEstate
    {
        return match ($realEstate['type_id']) {
            RealEstateType::residentialComplex => new ResidentialComplexRealEstate(
                ...[
                    ...collect($realEstateAttributes)
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
                    ...collect($realEstateAttributes)
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
                    ...collect($realEstateAttributes)
                        ->reduce(function ($accum, $nextValue, $nextKey) {
                            return [...$accum, Str::camel($nextKey) => $nextValue];
                        }, []),
                    'address' => $realEstate->address,
                    'typeId' => $realEstate->typeId,
                    'cityId' => $realEstate->cityId,
                    'id' => $realEstate->id,
                    'houseId' => $realEstate->parentId
                ]
            ),
            default => null,
        };
    }
}
