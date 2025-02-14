<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use Yii;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class SelfTasksController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new TasksSearch();
        $searchModel->author_id = Yii::$app->user->getId();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
