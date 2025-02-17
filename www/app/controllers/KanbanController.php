<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\Service\BoardsService;
use app\Service\StatusService;
use app\Service\TaskService;

class KanbanController extends BaseController
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

    public function actionIndex(): string
    {
        $boards = $this->boardsService->getBoards(
            $this->statusService->getStatuses(),
            $this->taskService->findBy(),
            26,
        );

        return $this->render(
            'index',
            [
                'boards' => $boards,
            ],
        );
    }
}