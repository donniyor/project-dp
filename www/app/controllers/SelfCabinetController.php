<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Users;
use Exception;
use Throwable;
use app\components\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class SelfCabinetController extends BaseController
{
    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex(): string
    {
        $model = $this->findModel(Yii::$app->getUser()->getId());

        return $this->render('index', ['model' => $model]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function updateAction(int $id, Request $request): Response | string
    {
        $model = $this->findModel($id);

        if ($model->load($request->post())) {
            try {
                $model->setUsername($request->post('username'));
                $model->setEmail('password');
                $model->save();
            } catch (Exception) {
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
        } catch (Throwable) {
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
