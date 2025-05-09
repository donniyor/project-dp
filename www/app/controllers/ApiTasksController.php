<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\Service\BoardsService;
use app\Service\StatusService;
use app\Service\TaskService;
use yii\db\Exception;
use yii\web\Request;
use yii\web\Response;

class ApiTasksController extends BaseController
{
    private TaskService $taskService;
    private StatusService $statusService;
    private BoardsService $boardsService;

    public function __construct(
        $id,
        $module,
        TaskService $taskService,
        StatusService $statusService,
        BoardsService $boardsService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->taskService = $taskService;
        $this->statusService = $statusService;
        $this->boardsService = $boardsService;
    }

    public function actionData(Response $response): Response
    {
        $response->format = Response::FORMAT_JSON;

        return $this->asJson(
            $this->boardsService->getBoards(
                $this->statusService->getStatuses(),
                $this->taskService->findByDTO(),
            ),
        );
    }

    /**
     * @throws Exception
     */
    public function actionUpdateStatus(Request $request): Response
    {
        $taskId = (int)$request->post('taskId');
        $status = (int)$request->post('status');
        $task = $this->taskService->findById($taskId);

        if ($task !== null) {
            $this->taskService->update(
                $task,
                null,
                null,
                null,
                $status,
            );

            return $this->asJson(['status' => 'success']);
        }

        return $this->asJson(['status' => 'error', 'message' => 'Задача не найдена']);
    }
}
