<?php

declare(strict_types=1);

namespace app\Repository;

use app\components\Statuses\Statuses;

class StatusRepository
{
    private const ASC = 'asc';
    private const DESC = 'desc';

    public function getStatuses($sort = self::ASC): array
    {
        $statuses = Statuses::getStatusList();
        $sort === self::ASC ? asort($statuses) : arsort($statuses);

        return $statuses;
    }
}