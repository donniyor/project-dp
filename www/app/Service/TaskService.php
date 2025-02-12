<?php

declare(strict_types=1);

namespace app\Service;

use app\models\Tasks;
use app\Repository\TaskRepository;
use yii\data\ActiveDataProvider;

class TaskService
{
    private TaskRepository $repository;

    public function __construct(
        TaskRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function search(
        ?int $projectId = null,
        ?int $status = null,
        ?array $authorIds = null,
        ?array $assignedToIds = null,
    ): ActiveDataProvider {
        return $this->repository->search(
            $projectId,
            $status,
            $authorIds,
            $assignedToIds,
        );
    }

    public function create(): Tasks
    {
        return new Tasks();
    }
}