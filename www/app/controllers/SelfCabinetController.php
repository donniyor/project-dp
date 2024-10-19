<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Users;
use app\components\BaseController;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;

class SelfCabinetController extends BaseController
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionIndex(Request $request): string
    {
        $model = $this->findModel(Yii::$app->getUser()->getId());

        if ($model->load($request->post())) {
            $this->saveData($model, 'index', true, ['image_url']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
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
