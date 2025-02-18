<?php

declare(strict_types=1);

namespace app\Repository;

use app\models\Tasks;
use yii\data\ActiveDataProvider;

class TaskRepository extends BaseEntityRepository
{
    public function getEntity(): Tasks
    {
        return new Tasks();
    }

    public function search(
        ?int $projectId = null,
        ?int $status = null,
        ?array $authorIds = null,
        ?array $assignedToIds = null,
    ): ActiveDataProvider {
        $query = $this->getEntity()->find()->joinWith(['author', 'assignedTo']);

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
                $authorIds,
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

    public function create(
        string $title,
        string $description,
        int $statusId,
        int $projectId,
        int $authorId,
        ?int $assignedTo = null,
    ): Tasks {
        $model = $this->getEntity();

        $model->setTitle($title)
            ->setDescription($description)
            ->setStatus($statusId)
            ->setProjectId($projectId)
            ->setAuthorId($authorId);

        if ($assignedTo !== null) {
            $model->setAssignedTo($assignedTo);
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
        return $this->getEntity()->find()->with('project')->all();
    }

    public function update(
        Tasks $model,
        ?string $title = null,
        ?string $description = null,
        ?int $projectId = null,
        ?int $status = null,
        ?int $assignedTo = null
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
                ->joinWith(['author', 'assignedTo']),
        ]);
    }
}