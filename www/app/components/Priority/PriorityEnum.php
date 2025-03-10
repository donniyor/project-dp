<?php

declare(strict_types=1);

namespace app\components\Priority;

class PriorityEnum
{
    public const LOWEST = 1;
    public const LOW = 2;
    public const MEDIUM = 3;
    public const HIGH = 4;
    public const HIGHEST = 5;

    public static function getAll(): array
    {
        return [
            self::LOWEST,
            self::LOW,
            self::MEDIUM,
            self::HIGH,
            self::HIGHEST,
        ];
    }
}
