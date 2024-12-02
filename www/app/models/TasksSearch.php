<?php

declare(strict_types=1);

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TasksSearch extends Tasks
{
    public function rules(): array
    {
        return [
            [['status'], 'integer'],
            [['author_id', 'assigned_to', 'title', 'description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Tasks::find()->joinWith(['assignedTo', 'author']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->assigned_to)) {
            $query->andWhere(['in', 'tasks.assigned_to', $this->assigned_to]);
        }

        if (!empty($this->author_id)) {
            $query->andWhere(['in', 'tasks.author_id', $this->author_id]);
        }

        if (!empty($this->status)) {
            $query->andWhere(['in', 'tasks.status', $this->status]);
        }

        if (!empty($this->title)) {
            $query->andFilterWhere(['ilike', 'tasks.title', $this->title]);
        }

        return $dataProvider;
    }
}
