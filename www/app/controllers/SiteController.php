<?php

declare(strict_types=1);

namespace app\controllers;

use app\Service\TaskService;
use app\Service\UserService;
use Yii;
use yii\filters\AccessControl;
use app\components\BaseController;
use yii\filters\VerbFilter;

class SiteController extends BaseController
{
    private TaskService $taskService;
    private UserService $userService;

    public function __construct(
        $id,
        $module,
        TaskService $taskService,
        UserService $userService,
        $config = [],
    ) {
        parent::__construct(
            $id,
            $module,
            $config,
        );

        $this->taskService = $taskService;
        $this->userService = $userService;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['/auth/in']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'tasks' => $this->taskService->findByUserId(
                $this->userService->getCurrentUser()->getId(),
            ),
        ]);
    }
}
