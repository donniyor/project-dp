<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\KanbanTaskSearchDTO;
use app\Service\BoardsService;
use app\Service\ProjectService;
use app\Service\StatusService;
use app\Service\TaskService;
use app\Service\UserService;
use yii\web\Request;

class KanbanController extends BaseController
{
    private TaskService $taskService;
    private StatusService $statusService;
    private BoardsService $boardsService;
    private ProjectService $projectService;
    private UserService $userService;

    public function __construct(
        $id,
        $module,
        TaskService $taskService,
        StatusService $statusService,
        BoardsService $boardsService,
        ProjectService $projectService,
        UserService $userService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->taskService = $taskService;
        $this->statusService = $statusService;
        $this->boardsService = $boardsService;
        $this->projectService = $projectService;
        $this->userService = $userService;
    }

    public function actionIndex(Request $request): string
    {
        $searchDTO = KanbanTaskSearchDTO::fromArray($request->get());
        $tasks = $this->taskService->findByDTO($searchDTO);

        $projects = null;
        if (null !== $searchDTO->projectIds) {
            $projects = $this->projectService->findByIds(...$searchDTO->projectIds);
        }

        $assignedToIds = null;
        if (null !== $searchDTO->assignedToIds) {
            $assignedToIds
                = $this->userService->getUsersForView($this->userService->findByIds($searchDTO->assignedToIds));
        }

        return $this->render(
            'index',
            [
                'boards' => $this->boardsService->getBoards($this->statusService->getStatuses(), $tasks, 26),
                'projects' => $projects,
                'assignedToIds' => $assignedToIds,
                'filters' => $searchDTO->toArray(),
            ],
        );
    }
}
