<?php

declare(strict_types=1);

namespace app\Repository;

use app\components\Statuses\StatusesInterface;
use app\DTO\TaskCreateDTO;
use app\models\Tasks;
use yii\data\ActiveDataProvider;

class TaskRepository extends BaseEntityRepository
{
    protected function getEntity(): Tasks
    {
        return new Tasks();
    }

    public function search(
        ?int $projectId = null,
        ?int $status = null,
        ?array $authorIds = null,
        ?array $assignedToIds = null,
    ): ActiveDataProvider {
        $query = $this->getEntity()
            ->find()
            ->joinWith(['author', 'assignedTo'])
            ->with('assignedTo')
            ->with('author')
            ->with('project');

        if ($authorIds !== null) {
            $query->andWhere([
                'in',
                'tasks.author_id',
                $authorIds,
            ]);
        }

        if ($assignedToIds !== null) {
            $query->andWhere([
                'in',
                'tasks.assigned_to',
                $assignedToIds,
            ]);
        }

        if ($projectId !== null) {
            $query->andWhere(['tasks.project_id' => $projectId]);
        }

        if ($status !== null) {
            $query->andFilterWhere([
                'tasks.status' => $status,
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function create(TaskCreateDTO $createDTO, int $authorId): Tasks
    {
        $model = $this->getEntity();

        $model->setTitle($createDTO->getTitle())
            ->setDescription($createDTO->getDescription())
            ->setStatus($createDTO->getStatus())
            ->setProjectId($createDTO->getProjectId())
            ->setPriority($createDTO->getPriority())
            ->setAuthorId($authorId);

        if (null !== $createDTO->getAssignedTo()) {
            $model->setAssignedTo($createDTO->getAssignedTo());
        }

        $model->save();

        return $model;
    }

    public function findById(int $id): Tasks
    {
        return $this->getEntity()->findOne(['id' => $id]);
    }

    public function findBy(): array
    {
        return $this->getEntity()
            ->find()
            ->with('project')
            ->with('assignedTo')
            ->where(['!=', 'status', StatusesInterface::STATUS_DELETED])
            ->all();
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
        if ($title !== null) {
            $model->setTitle($title);
        }

        if ($description !== null) {
            $model->setDescription($description);
        }

        if ($projectId !== null) {
            $model->setProjectId($projectId);
        }

        if ($status !== null) {
            $model->setStatus($status);
        }

        if ($assignedTo !== null) {
            $model->setAssignedTo($assignedTo);
        }

        if (null !== $deadline) {
            $model->setDeadline($deadline);
        }

        if (null !== $priority) {
            $model->setPriority($priority);
        }

        $model->save();

        return $model;
    }

    public function findByUserId(int $userId): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->getEntity()
                ->find()
                ->orWhere(['tasks.assigned_to' => $userId,])
                ->orWhere(['tasks.author_id' => $userId])
                ->with('assignedTo')
                ->with('author')
                ->with('project')
                ->joinWith(['author', 'assignedTo']),
        ]);
    }
}