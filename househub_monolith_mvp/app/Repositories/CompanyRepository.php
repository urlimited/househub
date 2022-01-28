<?php

namespace App\Repositories;

use App\Contracts\Repositories\CompanyRepositoryContract;
use App\DTO\CompanyModelDTO;
use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\ServiceCompany;
use App\Repositories\Entities\CompanyEntity;
use App\Repositories\Entities\CompanyStatusHistoryEntity;
use JetBrains\PhpStorm\Pure;

final class CompanyRepository implements CompanyRepositoryContract
{
    public function create(CompanyModelDTO $companyData): Company
    {
        $companyEntity = CompanyEntity::create($companyData->companyEntityData);

        $companyStatusHistory = CompanyStatusHistoryEntity::create($companyData->companyStatusHistory);

        return $this->identifyCompany(companyStatusHistory: $companyStatusHistory, company: $companyEntity);
    }

    public function update(CompanyModelDTO $companyData): Company
    {
        $companyEntity = CompanyEntity::findOrFail($companyData->companyEntityData['id']);

        return $this->identifyCompany(companyStatusHistory: $companyStatusHistory, company: $companyEntity);
    }

    public function softDelete(int $id): Company
    {

    }

    public function delete(int $id): Company
    {

    }

    public function find(int $id): Company
    {

    }

    #[Pure]
    private function identifyCompany(
        CompanyStatusHistoryEntity $companyStatusHistory,
        CompanyEntity $company
    ): Company
    {
        return match ($company->typeId) {
            CompanyType::serviceCompany => new ServiceCompany (
                id: $company->id,
                name: $company->name,
                bin: $company->bin,
                typeId: $company->typeId,
                statusId: $companyStatusHistory->statusId,
                email: $company->email
            ),
            default => null,
        };
    }
}
