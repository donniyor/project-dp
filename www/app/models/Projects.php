<?php

declare(strict_types=1);

namespace app\models;

use app\components\Statuses\StatusesInterface;
use Yii;
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
 *author
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
            ['author_id', 'default', 'value' => Yii::$app->getUser()->getId()],
            [['status'], 'default', 'value' => StatusesInterface::STATUS_IN_WORK],
            [['author_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['author_id' => 'id'],
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

    public function getStatus(): int
    {
        return $this->getAttribute('status');
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    public function getAuthorModel(): Users
    {
        return $this->author;
    }

    public function getCreatedAt(): ?string
    {
        return $this->getAttribute('created_at');
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getAttribute('updated_at');
    }

    public function getDescription(): string
    {
        return $this->getAttribute('description') ?? '';
    }
}
