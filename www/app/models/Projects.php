<?php

declare(strict_types=1);

namespace app\models;

use app\components\Statuses\StatusesInterface;
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
            [['status'], 'default', 'value' => StatusesInterface::STATUS_TO_DO],
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

    public function getAuthorId(): int
    {
        return (int)$this->getAttribute('author_id');
    }

    public function getStatus(): int
    {
        return (int)$this->getAttribute('status');
    }

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

    public function getTitle(): string
    {
        return (string)$this->getAttribute('title');
    }

    public function getAuthorModel(): Users
    {
        return $this->author;
    }

    public function getCreatedAt(): ?string
    {
        return (string)$this->getAttribute('created_at');
    }

    public function getDescription(): string
    {
        return (string)$this->getAttribute('description') ?? '';
    }

    public function setTitle(string $title): self
    {
        $this->setAttribute('title', $title);

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->setAttribute('description', $description);

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->setAttribute('status', $status);

        return $this;
    }

    public function setAuthorId(int $id): self
    {
        $this->setAttribute('author_id', $id);

        return $this;
    }
}
