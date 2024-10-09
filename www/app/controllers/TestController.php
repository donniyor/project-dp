<?php

namespace app\controllers;

use app\components\Controller;
use app\models\ProblemSolving;
use app\models\Quizizz;
use app\models\QuizizzSearch;
use app\models\TestSolution;
use app\components\RolesInterface;
use yii\web\Request;
use yii\web\Response;
use app\components\BaseBehaviors;
use app\components\BaseModel;
use yii\db\ActiveQuery;
use yii\web\User;

class TestController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE]);
    }

    public function actionIndex(): string
    {
        $searchModel = new QuizizzSearch();

        $queryChange = function (ActiveQuery $query): void {
            $query->where(['status' => BaseModel::STATUS_ACTIVE]);
        };

        $dataProvider = $searchModel->search($this->request->queryParams, $queryChange);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id, Request $request, User $user): string|Response
    {
        $model = new TestSolution();
        $quiz = Quizizz::find()->where(['id' => $id])->with(['questions', 'questions.answerOptions'])->one();

        if (TestSolution::find()->where(['user_id' => $user->id, 'quiz_id' => $id])->count() === 0) {
            if ($request->isPost) {
                if ($request->post('answer') === null) {
                    $this->flash('danger', 'Пройдите тест полностью');
                    return $this->render('view', [
                        'model' => $model,
                        'quiz' => $quiz
                    ]);
                }

                if (count($request->post('answer')) !== count($quiz->questions)) {
                    $this->flash('danger', 'Ответьте на все вопросы');
                    return $this->render('view', [
                        'model' => $model,
                        'quiz' => $quiz
                    ]);
                }

                $model->quiz_id = $id;
                $model->user_id = $user->id;
                $model->save();

                foreach ($request->post('answer') as $item) {
                    $arr = explode('-', $item);
                    $problem_solving = new ProblemSolving();
                    $problem_solving->test_solution_id = $model->id;
                    $problem_solving->answer_id = $arr[0];
                    $problem_solving->question_id = $arr[1];
                    $problem_solving->save();
                }

                $this->flash('success', 'Данные успешно сохранены');
                return $this->redirect(['success']);
            }
            return $this->render('view', [
                'model' => $model,
                'quiz' => $quiz
            ]);
        }
        return $this->redirect(['success']);
    }

    public function actionSuccess(): string
    {
        return $this->render('success');
    }
}