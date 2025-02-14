<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;

class KanbanController extends BaseController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}