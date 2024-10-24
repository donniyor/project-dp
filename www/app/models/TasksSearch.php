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
        $query = Tasks::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->assigned_to)) {
            $query->where(['in', 'assigned_to', $this->assigned_to]);
        }

        if (!empty($this->author_id)) {
            $query->where(['in', 'author_id', $this->author_id]);
        }

        $query
            ->andFilterWhere(['status' => $this->status,])
            ->andFilterWhere(['ilike', 'title', $this->title])
            ->andFilterWhere(['ilike', 'description', $this->description]);

        return $dataProvider;
    }
}
