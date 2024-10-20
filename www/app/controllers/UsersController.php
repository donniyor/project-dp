<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\CreateAdminForm;
use app\models\Users;
use app\models\UsersSearch;
use Exception;
use Throwable;
use app\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class UsersController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(Request $request): Response | string
    {
        $model = new CreateAdminForm();

        if ($model->load($request->post())) {
            try {
                $model->createUser();
            } catch (Exception $e) {
                $this->flash('error', 'Ошибка: ' . $this->formatErrors($model));

                return $this->back();
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $user = $this->findModel($id);

        try {
            $user->delete();
        } catch (Throwable $e) {
            $this->flash('danger', 'Ошибка: ' . $this->formatErrors($user));

            return $this->back();
        }

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Users
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Users
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
