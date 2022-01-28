<?php

namespace App\Contracts\Repositories;

use App\DTO\CompanyModelDTO;
use App\Models\Company;

interface CompanyRepositoryContract
{
    public function create(CompanyModelDTO $companyData): Company;
    public function update(CompanyModelDTO $companyData): Company;
    public function softDelete(int $id): Company;
    public function delete(int $id): Company;
    public function find(int $id): Company;
}
