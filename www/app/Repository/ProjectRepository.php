<?php

declare(strict_types=1);

namespace app\Repository;

use app\DTO\ProjectSearchDTO;
use app\models\Projects;
use yii\data\ActiveDataProvider;

class ProjectRepository
{
    private Projects $projects;

    public function __construct(Projects $projects)
    {
        $this->projects = $projects;
    }

    public function search(ProjectSearchDTO $params): ActiveDataProvider
    {
        $query = $this->projects::find()->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params->getStatus() !== null) {
            $query->andFilterWhere([
                'projects.status' => $params->getStatus(),
            ]);
        }

        if ($params->getAuthorIds() !== null) {
            $query->where([
                'in',
                'author_id',
                $params->getAuthorIds(),
            ]);
        }

        return $dataProvider;
    }
}