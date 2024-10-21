<?php

declare(strict_types=1);

namespace app\components\Statuses;

interface StatusesInterface
{
    const STATUS_DELETED = -1;      // Проект удален
    const STATUS_IN_WORK = 1;       // В работе (проект активен)
    const STATUS_PAUSED = 2;        // Приостановлен (временно остановлен)
    const STATUS_DONE = 3;          // Завершен (все задачи выполнены)
    const STATUS_CANCELED = 4;      // Отменен (проект не будет выполнен)
    const STATUS_ARCHIVED = 5;      // Архивирован (проект завершен и перемещен в архив)
}