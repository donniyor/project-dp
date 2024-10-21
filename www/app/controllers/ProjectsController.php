<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\models\Projects;
use app\models\ProjectsSearch;
use Throwable;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws \yii\base\Exception
     * @throws HttpException
     */
    public function actionCreate(): Response | string
    {
        $model = new Projects();

        if ($this->request->isPost) {
            $this->saveData($model, 'update');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws \yii\base\Exception
     * @throws HttpException
     */
    public function actionUpdate(int $id): Response | string
    {
        $model = $this->findModel($id);

        if ($model->getId() !== Yii::$app->getUser()->getId()) {
            return $this->render('view', ['model' => $model]);
        }

        if ($this->request->isPost) {
            $this->saveData($model, 'update');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Projects
    {
        if (($model = Projects::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
