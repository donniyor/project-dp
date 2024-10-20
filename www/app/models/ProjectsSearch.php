<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProjectsSearch extends Projects
{
    public string $author_search = '';

    public function rules(): array
    {
        return [
            [['status'], 'integer'],
            [['title', 'author_search'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Projects::find()->joinWith('author');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'projects.status' => $this->status,
        ]);

        $query->andFilterWhere(['ilike', 'projects.title', $this->title])
            ->andFilterWhere([
                'or',
                ['ilike', 'users.first_name', $this->author_search],
                ['ilike', 'users.last_name', $this->author_search],
                ['ilike', 'users.username', $this->author_search],
                ['ilike', 'users.email', $this->author_search],
            ]);

        return $dataProvider;
    }
}
