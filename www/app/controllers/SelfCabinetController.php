<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Users;
use Throwable;
use app\components\BaseController;
use Yii;
use yii\base\InvalidRouteException;
use yii\web\BadRequestHttpException;
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
     * @throws InvalidRouteException
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     */
    public function actionUpdate(Request $request): Response | string
    {
        $model = $this->findModel(Yii::$app->getUser()->getId());

        if ($model->load($request->post())) {
            $this->saveData($model, 'update', true, ['image_url']);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
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
