<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TokenType extends Enum
{
    const access = 1;
    const refresh = 2;
}
