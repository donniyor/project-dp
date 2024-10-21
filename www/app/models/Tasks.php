<?php

namespace app\models;

use app\components\BaseModel;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property int $author_id
 * @property int|null $assigned_to
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
            [['author_id'], 'required'],
            [['author_id', 'assigned_to', 'status'], 'default', 'value' => null],
            [['author_id', 'assigned_to', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['author_id' => 'id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['assigned_to' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'author_id' => 'Author ID',
            'assigned_to' => 'Assigned To',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
}
