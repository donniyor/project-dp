<?php

declare(strict_types=1);

namespace app\components\Statuses;

interface StatusesInterface
{
    const STATUS_TO_DO = 1;
    const STATUS_DELETED = 22;
    const STATUS_IN_PROCESS = 3;
    const STATUS_NOT_OK = 4;
    const STATUS_OK = 5;
    const STATUS_DONE = 10;
}