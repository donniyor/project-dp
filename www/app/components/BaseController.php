<?php

declare(strict_types=1);

namespace app\components;

use Yii;
use yii\web\BadRequestHttpException;
use yii\base\InvalidRouteException;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{
    protected const SUCCESS = 'success';
    protected const DANGER = 'danger';

    public $enableCsrfValidation = true;
    public $error = null;

    /**
     * @throws InvalidRouteException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest && Yii::$app->controller->id !== 'auth') {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
            Yii::$app->getResponse()->redirect(['/auth/in'])->send();

            return false;
        }

        return true;
    }

    protected function formatErrors($model): string
    {
        $result = '';
        foreach ($model->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors) . " ";
        }
        return $result;
    }

    protected function makeError(array $errors): void
    {
        $this->flash(self::DANGER, implode(', ', array_map('implode', $errors)));
    }

    protected function flash(string $type, string $message): void
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }

    protected function back(): Response
    {
        return $this->redirect(Yii::$app->request->referrer);
    }
}
