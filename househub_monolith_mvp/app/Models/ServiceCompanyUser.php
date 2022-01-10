<?php

namespace App\Models;

use App\Enums\Role;

final class ServiceCompanyUser extends User
{
    public int $typeId = Role::serviceCompanyWorker;
}
