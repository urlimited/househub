<?php

namespace App\UseCases;

use App\Contracts\Repositories\RealEstateRepositoryContract;
use App\DTO\ApartmentRealEstateModelDTO;
use App\DTO\HouseRealEstateModelDTO;
use App\DTO\ResidentialComplexRealEstateModelDTO;

final class RealEstateUseCase
{
    private RealEstateRepositoryContract $realEstateRepository;

    public function __construct(RealEstateRepositoryContract $realEstateRepository)
    {
        $this->realEstateRepository = $realEstateRepository;
    }

    public function createApartmentRealEstate(array $realEstateData): UseCaseResult
    {
        if (key_exists('residential_complex_name', $realEstateData)) {
            $residentialComplex = $this->realEstateRepository
                ->create(ResidentialComplexRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['residential_complex_id'] = $residentialComplex->id;
        }


        if (key_exists('house_number', $realEstateData)) {
            $house = $this->realEstateRepository
                ->create(HouseRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['house_id'] = $house->id;
        }

        return new UseCaseResult(
            status: UseCaseResult::StatusSuccess,
            content: $this->realEstateRepository
                ->create(ApartmentRealEstateModelDTO::repositoryCreateData($realEstateData))
                ->publish()
        );

    }

    public function createHouseRealEstate(array $realEstateData): UseCaseResult
    {
        if (key_exists('residential_complex_name', $realEstateData)) {
            $residentialComplex = $this->realEstateRepository
                ->create(ResidentialComplexRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['residential_complex_id'] = $residentialComplex->id;
        }

        return new UseCaseResult(
            status: UseCaseResult::StatusSuccess,
            content: $this->realEstateRepository
                ->create(HouseRealEstateModelDTO::repositoryCreateData($realEstateData))
                ->publish()
        );
    }

    public function createResidentialComplexRealEstate(array $realEstateData): UseCaseResult
    {
        return new UseCaseResult(
            status: UseCaseResult::StatusSuccess,
            content: $this->realEstateRepository
                ->create(ResidentialComplexRealEstateModelDTO::repositoryCreateData($realEstateData))
                ->publish()
        );
    }

    public function updateApartmentRealEstate(array $realEstateData, int $id): UseCaseResult
    {
        $realEstateData['id'] = $id;

        if (key_exists('residential_complex_name', $realEstateData)) {
            $residentialComplex = $this->realEstateRepository
                ->create(ResidentialComplexRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['residential_complex_id'] = $residentialComplex->id;
        }


        if (key_exists('house_number', $realEstateData)) {
            $house = $this->realEstateRepository
                ->create(HouseRealEstateModelDTO::repositoryCreateData($realEstateData));

            $realEstateData['house_id'] = $house->id;
        }

        return new UseCaseResult(
            status: UseCaseResult::StatusSuccess,
            content: $this->realEstateRepository
                ->update(ApartmentRealEstateModelDTO::repositoryUpdateData($realEstateData))
                ->publish()
        );

    }
}
