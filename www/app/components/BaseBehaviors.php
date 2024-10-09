<?php

namespace app\components;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class BaseBehaviors {
    protected static function behaviors(array $array): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $array,
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

    public static function getBehaviors(array $array): array
    {
        return self::behaviors($array);
    }
}