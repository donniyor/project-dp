<?php

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "answer_options".
 *
 * @property int $id
 * @property string $answer
 * @property int $question_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ProblemSolving[] $problemSolvings
 * @property Questions $question
 */
class AnswerOptions extends BaseModel
{
    public static function tableName(): string
    {
        return 'answer_options';
    }

    public function rules(): array
    {
        return [
            [['answer', 'question_id'], 'required'],
            [['answer'], 'string'],
            [['status'], 'default', 'value' => BaseModel::STATUS_ACTIVE],
            [['question_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['question_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'answer' => 'Ответ',
            'question_id' => 'Вопрос',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
        ];
    }

    public function getProblemSolvings(): ActiveQuery
    {
        return $this->hasMany(ProblemSolving::class, ['answer_id' => 'id']);
    }

    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Questions::class, ['id' => 'question_id']);
    }

    protected function logTitle(): string
    {
        return 'ответ';
    }
}
