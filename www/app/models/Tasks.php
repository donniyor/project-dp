<?php

declare(strict_types=1);

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int $author_id
 * @property int|null $assigned_to
 * @property int $project_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ?Users $assignedTo
 * @property Users $author
 * @property Projects $project
 *
 */
class Tasks extends BaseModel
{
    public static function tableName(): string
    {
        return 'tasks';
    }

    public function rules(): array
    {
        return [
            [['title'], 'required'],
            [['description'], 'safe'],
            [['project_id'], 'required'],
            [['assigned_to', 'project_id', 'status'], 'default', 'value' => null],
            [['author_id', 'assigned_to', 'project_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'author_id' => 'Автор',
            'project_id' => 'Проект',
            'assigned_to' => 'Исполнитель',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
            'priority' => 'Приоритет',
            'deadline' => 'Дедлайн',
        ];
    }

    public function getAssignedToUserId(): ?int
    {
        return (int)$this->getAttribute('assigned_to') ?? null;
    }

    public function getAssignedTo(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'assigned_to']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Projects::class, ['id' => 'project_id']);
    }

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

    public function getTitle(): string
    {
        return $this->getAttribute('title') ?? '';
    }

    public function getDescription(): string
    {
        return (string)$this->getAttribute('description');
    }

    public function getProjectId(): ?int
    {
        return $this->getAttribute('project_id') === null
            ? null
            : (int)$this->getAttribute('project_id');
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getPriority(): int
    {
        return (int)$this->getAttribute('priority');
    }

    public function getDeadLine(): string
    {
        return (string)$this->getAttribute('deadline');
    }

    public function getAuthorModel(): ?Users
    {
        return $this->author;
    }

    public function getAssignedToModel(): ?Users
    {
        return $this->assignedTo;
    }

    public function getCreatedAt(): string
    {
        return (string)$this->getAttribute('created_at');
    }

    public function setAssignedTo(int $assignedTo): void
    {
        $this->setAttribute('assigned_to', $assignedTo);
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

    public function setAuthorId(int $authorId): self
    {
        $this->setAttribute('author_id', $authorId);

        return $this;
    }

    public function setProjectId(int $projectId): self
    {
        $this->setAttribute('project_id', $projectId);

        return $this;
    }

    public function setDeadline(string $deadline): self
    {
        $this->setAttribute('deadline', $deadline);

        return $this;
    }

    public function setPriority(int $priority): self
    {
        $this->setAttribute('priority', $priority);

        return $this;
    }

    public function getProjectModel(): ?Projects
    {
        return $this->getRelatedRecords()['project'] ?? null;
    }
}
