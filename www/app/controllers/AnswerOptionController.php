<?php

namespace app\controllers;

use app\components\Controller;
use app\helpers\AnswerForm;
use app\models\AnswerOptions;
use app\components\RolesInterface;
use Yii;
use app\components\BaseBehaviors;
use yii\web\Response;

class AnswerOptionController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE, RolesInterface::ADMIN_ROLE]);
    }

    public function actionSaveAnswer(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $model = $id !== null ? AnswerOptions::findOne($id) : new AnswerOptions;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['success' => true, 'id' => $model->id];
        }

        return ['success' => false, 'errors' => $model->getErrors()];
    }

    public function actionAnswer(): string
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return AnswerForm::renderAnswer(new AnswerOptions(), Yii::$app->request->post('question_id'));
    }
}