<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int $author_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Users $author
 */
class Projects extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'projects';
    }

    public function rules(): array
    {
        return [
            [['description'], 'string'],
            [['author_id'], 'required'],
            [['author_id', 'status'], 'default', 'value' => null],
            [['author_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['author_id' => 'id']
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название проекта',
            'description' => 'Описание',
            'author_id' => 'Автор',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }
}
