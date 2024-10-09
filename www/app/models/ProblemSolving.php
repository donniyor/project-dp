<?php

namespace app\models;

use app\components\BaseModel;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "problem_solving".
 *
 * @property int $id
 * @property int $question_id
 * @property int $answer_id
 * @property int $test_solution_id
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property AnswerOptions $answer
 * @property Questions $question
 * @property TestSolution $testSolution
 */
class ProblemSolving extends BaseModel
{
    public static function tableName(): string
    {
        return 'problem_solving';
    }

    public function rules(): array
    {
        return [
            [['question_id', 'answer_id', 'test_solution_id'], 'required'],
            [['question_id', 'answer_id', 'test_solution_id', 'status'], 'default', 'value' => null],
            [['question_id', 'answer_id', 'test_solution_id', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['created_at', 'updated_at', 'status'], 'safe'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => AnswerOptions::class, 'targetAttribute' => ['answer_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::class, 'targetAttribute' => ['question_id' => 'id']],
            [['test_solution_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestSolution::class, 'targetAttribute' => ['test_solution_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'question_id' => 'QuestionForm ID',
            'answer_id' => 'Answer ID',
            'test_solution_id' => 'Test Solution ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getAnswer(): ActiveQuery
    {
        return $this->hasOne(AnswerOptions::class, ['id' => 'answer_id']);
    }

    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Questions::class, ['id' => 'question_id']);
    }

    public function getTestSolution(): ActiveQuery
    {
        return $this->hasOne(TestSolution::class, ['id' => 'test_solution_id']);
    }

    protected function logTitle(): string
    {
        return 'ответ на вопрос';
    }
}
