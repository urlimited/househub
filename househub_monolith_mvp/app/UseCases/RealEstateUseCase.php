<?php

namespace App\UseCases;

use App\Contracts\Repositories\RealEstateRepositoryContract;
use App\DTO\ApartmentRealEstateModelDTO;
use App\DTO\HouseRealEstateModelDTO;
use App\DTO\ResidentialComplexRealEstateModelDTO;
use Illuminate\Contracts\Container\BindingResolutionException;

final class RealEstateUseCase
{
    private RealEstateRepositoryContract $realEstateRepository;

    /**
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->realEstateRepository = app()->make(RealEstateRepositoryContract::class);
    }

    public function createApartmentRealEstate(array $realEstateData): array
    {
        if(key_exists('residential_complex_name', $realEstateData)) {
            $residentialComplex = $this->realEstateRepository->create(ResidentialComplexRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['residential_complex_id'] = $residentialComplex->id;
        }


        if(key_exists('house_number', $realEstateData)){
            $house = $this->realEstateRepository->create(HouseRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['house_id'] = $house->id;
        }

        $apartment = $this->realEstateRepository->create(ApartmentRealEstateModelDTO::repositoryCreateData($realEstateData));

        return $apartment->publish();
    }

    public function createHouseRealEstate(array $realEstateData): array
    {
        return [];
    }

    public function createResidentialComplexRealEstate(array $realEstateData): array
    {
        return [];
    }
}
