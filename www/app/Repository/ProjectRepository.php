<?php

declare(strict_types=1);

namespace app\Repository;

use app\DTO\Arrayable;
use app\DTO\ProjectSearchDTO;
use app\models\Projects;
use app\models\ProjectsSearch;
use yii\data\ActiveDataProvider;

class ProjectRepository
{
    private ProjectsSearch $projectsSearch;

    public function __construct(ProjectsSearch $projectsSearch)
    {
        $this->projectsSearch = $projectsSearch;
    }

    public function search(ProjectSearchDTO $params): ActiveDataProvider
    {
        $query = Projects::find()->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params->getStatus() !== null) {
            $query->andFilterWhere([
                'projects.status' => $params->getStatus(),
            ]);
        }

        if ($params->getTitle() !== null) {
            $query->andFilterWhere(['ilike', 'projects.title', $params->getTitle()]);
        }

        if ($params->getAuthorSearch() !== null) {
            $query->andFilterWhere([
                'or',
                ['ilike', 'users.first_name', $params->getAuthorSearch()],
                ['ilike', 'users.last_name', $params->getAuthorSearch()],
                ['ilike', 'users.username', $params->getAuthorSearch()],
                ['ilike', 'users.email', $params->getAuthorSearch()],
            ]);
        }

        return $dataProvider;
    }
}