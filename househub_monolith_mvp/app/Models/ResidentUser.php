<?php

namespace App\Models;

use App\Enums\Role;

final class ResidentUser extends User
{
    public int $typeId = Role::resident;
}
