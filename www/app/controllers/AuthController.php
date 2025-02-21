<?php

namespace app\controllers;

use app\DTO\AuthRequest;
use app\DTO\RegistrationRequest;
use app\Service\AuthService;
use app\Service\UserService;
use Yii;
use app\components\BaseController;
use yii\web\Request;
use yii\web\Response;


class AuthController extends BaseController
{
    private AuthService $authService;
    private UserService $userService;

    public function __construct(
        $id,
        $module,
        AuthService $authService,
        UserService $userService,
        $config = [],
    ) {
        parent::__construct(
            $id,
            $module,
            $config,
        );

        $this->authService = $authService;
        $this->userService = $userService;
    }

    public $layout = 'sign';

    public function actionIn(Request $request): string | Response
    {
        if (!$this->userService->getCurrentUser()->isGuest) {
            return $this->goHome();
        }

        $data = $request->post();

        if ($request->getIsPost() && $request->validateCsrfToken()) {
            $data = AuthRequest::fromArray($data);

            $isValid = $this->authService->login($data->username, $data->password);
            if ($isValid) {
                $this->redirect('/');
            }

            $this->flash(self::DANGER, 'Неправильный логин или пароль');
            $data = $data->toArray();
        }

        $data['password'] = '';

        return $this->render('login', ['data' => $data]);
    }

    public function actionRegistration(Request $request): string | Response
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $data = $request->post();
        if ($request->getIsPost()) {
            $data = RegistrationRequest::fromArray($data);

            $this->authService->registration(
                $data->username,
                $data->password,
            );
        }

        $data['password'] = '';

        return $this->render('registration', ['data' => $data]);
    }

    public function actionOut(): Response
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->user->getReturnUrl(['/auth/in']));
    }
}
