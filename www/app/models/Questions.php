<?php

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property string $question
 * @property int $quiz_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AnswerOptions[] $answerOptions
 * @property ProblemSolving[] $problemSolvings
 * @property Quizizz $quiz
 */
class Questions extends BaseModel
{
    public static function tableName(): string
    {
        return 'questions';
    }

    public function rules(): array
    {
        return [
            [['question', 'quiz_id'], 'required'],
            [['question'], 'string'],
            [['status'], 'default', 'value' => BaseModel::STATUS_ACTIVE],
            [['quiz_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['quiz_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quizizz::class, 'targetAttribute' => ['quiz_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'question' => 'Вопрос',
            'quiz_id' => 'Опрос',
            'status' => 'Статус',
            'created_at' => 'Дата добавления',
            'updated_at' => 'Дата редактирования',
        ];
    }

    public function getAnswerOptions(): ActiveQuery
    {
        return $this->hasMany(AnswerOptions::class, ['question_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public function getProblemSolvings(): ActiveQuery
    {
        return $this->hasMany(ProblemSolving::class, ['question_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public function getQuiz(): ActiveQuery
    {
        return $this->hasOne(Quizizz::class, ['id' => 'quiz_id'])->orderBy(['created_at' => SORT_ASC]);
    }

    protected function logTitle(): string
    {
        return 'вопрос';
    }

    public function answerOptionsArray(): array
    {
        return ArrayHelper::map($this->answerOptions, 'id', 'answer');
    }
}
