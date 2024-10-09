<?php

namespace app\components;

use app\helpers\Upload;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\base\InvalidRouteException;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action): bool
    {
        if (!parent::beforeAction($action))
            return false;

        if (Yii::$app->user->isGuest && Yii::$app->controller->id !== 'auth') {
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
            Yii::$app->getResponse()->redirect(['/auth/in'])->send();
            return false;
        } else {
            return true;
        }
    }

    public $enableCsrfValidation = true;
    public $error = null;

    /**
     * @throws InvalidRouteException
     * @throws BadRequestHttpException
     */

    public function saveData($model, $type = 'create', $imageUpload = false, $images = [])
    {
        $controller = Yii::$app->controller->getUniqueId();
        $env = env('API_HOST');
        if ($model->load($this->request->post())) {
            if (isset($_FILES) && $imageUpload && !empty($images)) {
                foreach ($images as $image) {
                    $imageInstance = UploadedFile::getInstance($model, $image);
                    $model->$image = $imageInstance;

                    if ($imageInstance && $model->validate($image)) {
                        try {
                            $model->$image = $env . Upload::fileAlias($imageInstance);
                        } catch (HttpException $e) {
                        } catch (Exception $e) {
                        }
                    } else {
                        $model->$image = $type === 'update' ? $model->oldAttributes[$image] : '';
                    }
                }
            }

            if ($model->save()) {
                $this->flash('success', 'Данные успешно сохранены');

                if ($model->isNewRecord) {
                    return $this->redirect(['index']);
                } else {
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            } else {
                $this->flash('error', 'Ошибка: ' . $this->formatErrors($model));

                if ($model->isNewRecord) {
                    return $this->render('create', ['model' => $model]);
                } else {
                    return $this->render('update', ['model' => $model]);
                }
            }
        }
        return false;
    }

    public function formatErrors($model): string
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
