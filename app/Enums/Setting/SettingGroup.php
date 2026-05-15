<?php

namespace App\Enums\Setting;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static General()
 * @method static static UserDiscount()
 * @method static static UserUpgrade()
 */
final class SettingGroup extends Enum implements LocalizedEnum
{
    const General = 1;
    const UserDiscount = 2;
    const UserUpgrade = 3;
    const Footer = 4;
    const Contact = 5;
    const Information = 6;
    const Slider = 7;
}
