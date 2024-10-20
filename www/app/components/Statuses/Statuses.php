<?php

declare(strict_types=1);

namespace app\components\Statuses;

class Statuses implements StatusesInterface
{
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_DELETED => 'Удален'
        ];
    }

    public static function getStatusName(int $status): string
    {
        $status = self::getStatusList()[$status];
        if ($status) {
            return $status;
        }

        return 'Не определен';
    }
}