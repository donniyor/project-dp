<?php

declare(strict_types=1);

namespace app\Service;

use app\components\Statuses\Statuses;
use app\Repository\StatusRepository;

class StatusService
{
    private StatusRepository $repository;

    public function __construct(StatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getStatuses(): array
    {
        return $this->repository->getStatuses();
    }
}