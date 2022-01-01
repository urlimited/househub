<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserStatus extends Enum
{
    const registered = 1;
    const approved = 2;
    const blocked = 3;
    const loginConfirmed = 4;
    const deleted = 5;
}
