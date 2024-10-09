<?php

namespace app\controllers;

use app\models\Quizizz;
use app\models\QuizizzSearch;
use app\components\Controller;
use app\models\TestSolution;
use app\components\BaseBehaviors;
use app\components\BaseModel;
use app\models\Users;
use app\components\RolesInterface;
use Yii;
use yii\db\ActiveQuery;

class TestSolutionController extends Controller
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

            if (!Users::isSuperAdminStatic()) {
                $query->where(['user_id' => Yii::$app->user->id]);
            }
        };

        $dataProvider = $searchModel->search($this->request->queryParams, $queryChange);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): string
    {
        return $this->render('view', [
            'quiz' => Quizizz::find()->where(['id' => $id])->with([
                'questions',
                'questions.answerOptions',
                'questions.answerOptions.problemSolvings'
            ])->one(),
            'testSolution' => TestSolution::find()->where(['quiz_id' => $id])->all()
        ]);
    }
}
