<?php

declare(strict_types=1);

namespace app\components;

use app\helpers\Upload;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\base\InvalidRouteException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class BaseController extends Controller
{
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

    public $enableCsrfValidation = true;
    public $error = null;

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function saveData($model, $type = 'create', $imageUpload = false, $images = []): bool
    {
        $env = env('API_HOST');
        if ($model->load($this->request->post())) {
            if (isset($_FILES) && $imageUpload && !empty($images)) {
                foreach ($images as $image) {
                    $imageInstance = UploadedFile::getInstance($model, $image);
                    $model->$image = $imageInstance;

                    if ($imageInstance && $model->validate($image)) {
                        $model->$image = $env . Upload::file($imageInstance);
                    } else {
                        $model->$image = $type === 'update' ? $model->oldAttributes[$image] : '';
                    }
                }
            }

            if ($model->save()) {
                $this->flash('success', 'Данные успешно сохранены');

                return true;
            }
        }
        $this->flash('error', 'Ошибка: ' . $this->formatErrors($model));

        return false;
    }

    protected function formatErrors($model): string
    {
        $result = '';
        foreach ($model->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors) . " ";
        }
        return $result;
    }

    public function flash(string $type, string $message): void
    {
        Yii::$app->getSession()->setFlash($type == 'error' ? 'danger' : $type, $message);
    }

    public function back(): Response
    {
        return $this->redirect(Yii::$app->request->referrer);
    }

}
