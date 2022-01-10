<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CompanyStatus extends Enum
{
    const registered = 1;
    const approved = 2;
    const blocked = 3;
}
