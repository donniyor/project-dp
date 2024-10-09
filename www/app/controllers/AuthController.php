<?php
namespace app\controllers;

use app\models\CreateAdminForm;
use app\models\Users;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use Yii;
use app\components\Controller;
use app\models\LoginForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Response;


class AuthController extends Controller
{
    public $layout = 'sign';

    public function actionIn(): string|Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSingUp(): string|Response
    {
        $model = new CreateAdminForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->createUser();
            return $this->redirect(['in']);
        }

        return $this->render('sing-up', ['model' => $model]);
    }

    public function actionOut(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->user->getReturnUrl(['/auth/in']));
    }

    public function actionRequestPasswordReset(): Response|string
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token): string|Response
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerifyEmail(string $token): string
    {
        $user = Users::findByVerificationToken($token);
        $user->status = Users::STATUS_ACTIVE;
        $user->save();
        $this->flash('success', 'Вы успешно подтвердили свою почту.');
        return $this->render('VerifyEmail');
    }
}
