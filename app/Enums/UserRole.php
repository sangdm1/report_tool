<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const PM = 1;
    const LEADER = 2;
    const MEMBER = 3;
}
