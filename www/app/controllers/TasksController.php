<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\models\Tasks;
use app\models\TasksSearch;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TasksController extends BaseController
{
    public function actionIndex(): string
    {
        $viewType = Yii::$app->request->cookies->getValue('viewType', 'kanban');
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewType' => $viewType,
        ]);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionSetViewType(string $type): Response
    {
        if (!in_array($type, ['kanban', 'table'], true)) {
            throw new BadRequestHttpException('Invalid view type.');
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'viewType',
            'value' => $type,
            'expire' => time() + 3600 * 24 * 30,
        ]));

        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate(): Response | string
    {
        $model = new Tasks();

        if ($this->request->isPost) {
            if (!$this->saveData($model)) {
                return $this->back();
            }

            return $this->redirect(['update', 'id' => $model->getId()]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionUpdate(int $id): string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $this->saveData($model);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionAssign(int $id): Response | string
    {
        $model = $this->findModel($id);
        $model->setAssignedTo((int)Yii::$app->getUser()->getId());

        if ($model->validate() && $model->save() && Yii::$app->request->isAjax) {
            return $this->renderPartial('_assigned_cell', ['model' => $model]);
        }

        return $this->back();
    }


    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Tasks
    {
        if (($model = Tasks::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
