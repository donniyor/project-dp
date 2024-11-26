<?php

declare(strict_types=1);

namespace app\components\Statuses;

interface StatusesInterface
{
    const STATUS_DELETED = -1;      // удален
    const STATUS_TO_DO = 0;      // удален
    const STATUS_IN_WORK = 1;       // В работе (активен)
    const STATUS_PAUSED = 2;        // Приостановлен (временно остановлен)
    const STATUS_DONE = 3;          // Завершен (все задачи выполнены)
    const STATUS_CANCELED = 4;      // Отменен (не будет выполнен)
    const STATUS_ARCHIVED = 5;      // Архивирован (завершен и перемещен в архив)
}