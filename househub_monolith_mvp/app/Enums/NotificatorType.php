<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NotificatorType extends Enum
{
    const call = 1;
    const sms = 2;
    const email = 3;
}
