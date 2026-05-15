<?php

namespace App\Enums\Admin;

use App\Supports\Enum;

enum EducationLevel: int
{
    use Enum;

        // Sơ cấp
    case Primary = 1;

        // Trung cấp
    case Intermediate = 2;

        // Cao cấp
    case Advanced = 3;

    public function badge(): string
    {
        return match ($this) {
            EducationLevel::Primary => 'bg-green-lt',       // Màu cho Sơ cấp
            EducationLevel::Intermediate => 'bg-yellow-lt',  // Màu cho Trung cấp
            EducationLevel::Advanced => 'bg-blue-lt',        // Màu cho Cao cấp
        };
    }
}
