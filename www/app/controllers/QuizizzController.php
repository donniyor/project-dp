<?php

namespace app\controllers;

use app\models\Quizizz;
use app\models\QuizizzSearch;
use app\components\RolesInterface;
use Throwable;
use app\components\Controller;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use app\components\BaseBehaviors;
use app\components\BaseModel;
use app\models\Users;
use Yii;
use yii\db\ActiveQuery;

class QuizizzController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE]);
    }
    public function actionIndex(): string
    {
        $searchModel = new QuizizzSearch();

        $queryChange = function(ActiveQuery $query): void {
            if(!Users::isSuperAdminStatic()){
                $query->where(['user_id' => Yii::$app->user->id])->andWhere(['!=', 'status', BaseModel::STATUS_DELETED]);
            }
        };

        $dataProvider = $searchModel->search($this->request->queryParams, $queryChange);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(): string|Response
    {
        $model = new Quizizz();

        if ($this->request->isPost) {
            return $this->saveData($model, 'create');
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): string|Response
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            return $this->saveData($model, 'update');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Quizizz
    {
        if (($model = Quizizz::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMake(int $id): string
    {
        return $this->render('make', [
            'quiz' => Quizizz::find()->where(['id' => $id])->orderBy(['created_at' => SORT_ASC])->with('questions')->one(),
        ]);
    }
}
