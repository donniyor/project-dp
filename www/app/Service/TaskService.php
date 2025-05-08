<?php

declare(strict_types=1);

namespace app\Service;

use app\DTO\TaskCreateDTO;
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

    public function create(TaskCreateDTO $createDTO, int $authorId): Tasks
    {
        return $this->repository->create($createDTO, $authorId);
    }

    public function findById(int $id): ?Tasks
    {
        return $this->repository->findById($id);
    }

    public function findBy(): array
    {
        return $this->repository->findBy();
    }

    public function update(
        Tasks $model,
        ?string $title = null,
        ?string $description = null,
        ?int $projectId = null,
        ?int $status = null,
        ?int $assignedTo = null,
        ?string $deadline = null,
        ?int $priority = null,
    ): Tasks {
        return $this->repository->update(
            $model,
            $title,
            $description,
            $projectId,
            $status,
            $assignedTo,
            $deadline,
            $priority,
        );
    }

    public function findByUserId(int $userId): ActiveDataProvider
    {
        return $this->repository->findByUserId($userId);
    }
}