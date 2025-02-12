<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\Service\StatusService;
use yii\web\Response;

class StatusesController extends BaseController
{
    private StatusService $service;

    public function __construct(
        $id,
        $module,
        StatusService $service,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->service = $service;
    }

    public function actionGetStatus(Response $response): array
    {
        $response->format = Response::FORMAT_JSON;
        $statuses = $this->service->getStatuses();

        $result = [];
        foreach ($statuses as $key => $status) {
            $result[] = [
                'id' => $key,
                'title' => $status,
            ];
        }

        return $result;
    }
}