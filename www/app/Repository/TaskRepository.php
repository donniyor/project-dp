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
}