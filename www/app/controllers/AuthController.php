<?php

namespace app\controllers;

use app\DTO\AuthRequest;
use app\DTO\RegistrationRequest;
use app\Exception\RegistrationException;
use app\Service\AuthService;
use app\Service\UserService;
use app\Validator\UserRegistrationValidator;
use Yii;
use app\components\BaseController;
use yii\web\Request;
use yii\web\Response;


class AuthController extends BaseController
{
    private AuthService $authService;
    private UserService $userService;
    private UserRegistrationValidator $registrationValidator;

    public function __construct(
        $id,
        $module,
        AuthService $authService,
        UserService $userService,
        UserRegistrationValidator $registrationValidator,
        $config = [],
    ) {
        parent::__construct(
            $id,
            $module,
            $config,
        );

        $this->authService = $authService;
        $this->userService = $userService;
        $this->registrationValidator = $registrationValidator;
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
            $err = $this->registrationValidator->validate($data);
            if ($err !== null) {
                $this->makeError($err);
            }

            $data = RegistrationRequest::fromArray($data);

            try {
                $this->authService->registration(
                    $data->username,
                    $data->email,
                    $data->password,
                );
            } catch (RegistrationException $e) {
                $this->flash(self::DANGER, $e->getMessage());
            }

            $data = $data->toArray();
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
