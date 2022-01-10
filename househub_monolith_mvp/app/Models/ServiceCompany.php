<?php

namespace App\Models;

use App\Enums\CompanyType;

final class ServiceCompany extends Company
{
    public int $typeId = CompanyType::serviceCompany;
}
