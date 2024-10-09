<?php

namespace app\controllers;

use app\models\LogActions;
use app\models\LogActionsSearch;
use app\components\RolesInterface;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\components\BaseBehaviors;
/**
 * LogActionsController implements the CRUD actions for LogActions model.
 */
class LogActionsController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE]);
    }

    /**
     * Lists all LogActions models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LogActionsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the LogActions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return LogActions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogActions::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
