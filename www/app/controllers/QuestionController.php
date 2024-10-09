<?php

namespace app\controllers;

use app\components\Controller;
use app\models\Questions;
use app\components\RolesInterface;
use Yii;
use yii\web\Response;
use app\components\BaseBehaviors;

class QuestionController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE, 'admin']);
    }

    public function actionSaveQuestion(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = $id !== null ? Questions::findOne($id) : new Questions();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['success' => true, 'id' => $model->id];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionQuestion(int $id): string
    {
        return $this->renderPartial('question', [
            'question' => new Questions(),
            'id' => $id
        ]);
    }
}