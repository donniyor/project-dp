<?php

namespace app\models;

use Yii;

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
 * @property Comments[] $comments
 * @property RelatedTasks[] $relatedTasks
 * @property RelatedTasks[] $relatedTasks0
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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

    /**
     * Gets query for [[AssignedTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(Users::class, ['id' => 'assigned_to']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Users::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[RelatedTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedTasks()
    {
        return $this->hasMany(RelatedTasks::class, ['first_task_id' => 'id']);
    }

    /**
     * Gets query for [[RelatedTasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedTasks0()
    {
        return $this->hasMany(RelatedTasks::class, ['second_task_id' => 'id']);
    }
}
