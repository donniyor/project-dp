<?php

declare(strict_types=1);

namespace app\models;

use app\components\Avatars;
use app\components\BaseModel;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

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
 * @property Users $assignedTo
 * @property Users $author
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
            [['description'], 'string'],
            [['author_id', 'project_id'], 'required'],
            ['author_id', 'default', 'value' => Yii::$app->getUser()->getId()],
            [['assigned_to', 'project_id', 'status'], 'default', 'value' => null],
            [['author_id', 'assigned_to', 'project_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['author_id' => 'id']
            ],
            [
                ['project_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Projects::class,
                'targetAttribute' => ['project_id' => 'id']
            ],
            [
                ['assigned_to'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::class,
                'targetAttribute' => ['assigned_to' => 'id']
            ],
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
        ];
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
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->getTitle() ?? '';
    }

    public function getProjectsModel(): int
    {
        return $this->project_id;
    }

    public function getAllProjects(): array
    {
        return ArrayHelper::map(Projects::find()->select(['id', 'title'])->all(), 'id', 'title');
    }

    public function getAllUsers(): array
    {
        $users = Users::find()->select(['id', 'username', 'email', 'first_name', 'last_name'])->all();
        $total = [];
        /** @var Users $user */
        foreach ($users as $user) {
            $total[] = [
                'id' => $user->getId(),
                'user' => sprintf(
                    '%s%s',
                    Avatars::getAvatarRound($user, 50, false),
                    $user->getFirstName() ?? 'Нет значения'
                )
            ];
        }

        return ArrayHelper::map($total, 'id', 'user');
    }
}