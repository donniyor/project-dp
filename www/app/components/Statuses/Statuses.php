<?php

declare(strict_types=1);

namespace app\components\Statuses;

class Statuses implements StatusesInterface
{
    public static function getStatusList(): array
    {
        return [
            self::STATUS_IN_WORK => 'В работе',
            self::STATUS_DONE => 'Завершен',
            self::STATUS_DELETED => 'Удален',
        ];
    }

    public static function getStatusName(int $status): string
    {
        $statuses = self::getStatusList();
        if (isset($statuses[$status])) {
            return $statuses[$status];
        }

        return 'Не определен';
    }
}