<?php

declare(strict_types=1);

namespace app\components\Statuses;

interface StatusesInterface
{
    const STATUS_DELETED = -1;
    const STATUS_IN_WORK = 1;
    const STATUS_DONE = 2;
}