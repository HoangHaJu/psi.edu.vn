<?php

namespace App\Enums\User;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static Active()
 * @method static static Locked()

 */
final class UserStatus extends Enum implements LocalizedEnum
{
    const Active = 1;
    const Locked = 2;


}
