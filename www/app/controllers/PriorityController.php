<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\Repository\PriorityRepository;
use yii\web\Response;

class PriorityController extends BaseController
{
    private PriorityRepository $priorityRepository;

    public function __construct(
        $id,
        $module,
        PriorityRepository $priorityRepository,
        $config = [],
    ) {
        parent::__construct(
            $id,
            $module,
            $config,
        );

        $this->priorityRepository = $priorityRepository;
    }

    public function actionGetPriorities(Response $response): Response
    {
        $response->format = Response::FORMAT_JSON;

        return $this->asJson($this->priorityRepository->findAll());
    }
}