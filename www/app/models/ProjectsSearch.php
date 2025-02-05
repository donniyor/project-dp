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
}
