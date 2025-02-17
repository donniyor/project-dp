<?php

declare(strict_types=1);

namespace app\Service;

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

    public function getStatuesForView(array $statues): array
    {
        $result = [];
        foreach ($statues as $key => $status) {
            $result[] = [
                'id' => $key,
                'title' => $status,
            ];
        }

        return $result;
    }
}