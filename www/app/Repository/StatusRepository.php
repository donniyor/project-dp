<?php

declare(strict_types=1);

namespace app\Repository;

use app\components\Statuses\Statuses;

class StatusRepository
{
    public function getStatuses(): array
    {
        return Statuses::getStatusList();
    }
}