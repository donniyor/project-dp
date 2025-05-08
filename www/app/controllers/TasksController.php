<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\TaskCreateDTO;
use app\DTO\TaskSearchDTO;
use app\DTO\TaskUpdateDTO;
use app\models\Users;
use app\Repository\PriorityRepository;
use app\Service\ProjectService;
use app\Service\StatusService;
use app\Service\TaskService;
use app\Service\UserService;
use app\Validator\TaskUpdateValidator;
use app\Validator\TaskCreateValidator;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class TasksController extends BaseController
{
    private TaskService $tasksService;
    private UserService $userService;
    private TaskCreateValidator $taskCreateValidator;
    private TaskUpdateValidator $taskUpdateValidator;
    private StatusService $statusService;
    private ProjectService $projectService;
    private PriorityRepository $priorityRepository;

    public function __construct(
        $id,
        $module,
        TaskService $tasksService,
        UserService $userService,
        TaskCreateValidator $taskCreateValidator,
        TaskUpdateValidator $taskUpdateValidator,
        StatusService $statusService,
        ProjectService $projectService,
        PriorityRepository $priorityRepository,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->tasksService = $tasksService;
        $this->userService = $userService;
        $this->taskCreateValidator = $taskCreateValidator;
        $this->taskUpdateValidator = $taskUpdateValidator;
        $this->statusService = $statusService;
        $this->projectService = $projectService;
        $this->priorityRepository = $priorityRepository;
    }

    public function actionIndex(Request $request): string
    {
        // TODO validate request
        $params = TaskSearchDTO::fromArray($request->get());
        $tasks = $this->tasksService->search(
            $params->getProjectIds(),
            $params->getStatus(),
            $params->getAuthorIds(),
            $params->getAssignedToIds(),
        );

        $userIds = array_unique(
            array_merge(
                $params->getAuthorIds() ?? [],
                $params->getAssignedToIds() ?? [],
            ),
        );

        $authors = $assignedTo = null;
        if (!empty($userIds)) {
            $users = $this->userService->findByIds($userIds);

            $authors = !empty($params->getAuthorIds())
                ? $this->userService->getUsersForView(
                    array_filter(
                        $users,
                        static fn(Users $user): bool => in_array($user->getId(), $params->getAuthorIds()),
                    ),
                )
                : null;

            $assignedTo = !empty($params->getAssignedToIds())
                ? $this->userService->getUsersForView(
                    array_filter(
                        $users,
                        static fn(Users $user): bool => in_array($user->getId(), $params->getAssignedToIds()),
                    ),
                )
                : null;
        }

        return $this->render('table', [
            'tasks' => $tasks,
            'filters' => $params->toArray(),
            'authors' => $authors,
            'assignedTo' => $assignedTo,
        ]);
    }

    /**
     * @throws InvalidConfigException
     */
    #[\ReturnTypeWillChange]
    public function actionCreate(Request $request): Response | string
    {
        if ($request->getIsGet()) {
            return $this->render('create');
        }

        $data = $request->post();
        $errors = $this->taskCreateValidator->validate($data);

        $data = TaskCreateDTO::fromArray($data);

        $project = null;
        if (null !== $data->getProjectId()) {
            $project = $this->projectService->findById($data->getProjectId());
        }

        $assignedTo = null;
        if (null !== $data->getAssignedTo()) {
            $assignedTo = $this->userService->getUsersForView(
                $this->userService->findByIds([$data->getAssignedTo()]),
            );
        }

        $priority = null;
        if (null !== $data->getPriority()) {
            $priority = $this->priorityRepository::findAll();
        }

        if (null !== $errors) {
            $this->makeError($errors);
        } else {
            $model = $this->tasksService->create(
                $data->getTitle(),
                $data->getDescription(),
                $data->getStatus(),
                $data->getProjectId(),
                $this->userService->getCurrentUser()->getId(),
                $data->getAssignedTo(),
            );

            $errors = $model->getErrors();
            if (empty($errors)) {
                return $this->redirect(['update', 'id' => $model->getId()]);
            }

            $this->makeError($errors);
        }

        return $this->render('create', [
            'task' => $data->toArray(),
            'project' => $project,
            'statuses' => $this->statusService->getStatuesForView($this->statusService->getStatuses()),
            'assignedTo' => $assignedTo,
            'priority' => $priority,
        ]);
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionUpdate(Request $request): string
    {
        $id = (int)($request->get()['id'] ?? null);

        if ($id <= 0) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = $this->tasksService->findById($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($request->getIsPost()) {
            $data = $request->post();
            $data = TaskUpdateDTO::fromArray($data);
            $errors = $this->taskUpdateValidator->validate($data->toArray());
            if ($errors !== null) {
                $this->makeError($errors);
            } else {
                $model = $this->tasksService->update(
                    $model,
                    $data->getTitle(),
                    $data->getDescription(),
                    $data->getProjectId(),
                    $data->getStatus(),
                    $data->getAssignedTo(),
                    $data->getDeadline(),
                    $data->getPriority(),
                );
            }
        }

        $assignedTo = null;
        if ($model->getAssignedToUserId() !== null) {
            $assignedTo = $this->userService->getUsersForView(
                $this->userService->findByIds([$model->getAssignedToUserId()]),
            );
        }

        $project = null;
        if ($model->getProjectId() !== null) {
            $project = $this->projectService->findById($model->getProjectId());
        }

        return $this->render('update', [
            'model' => $model,
            'assignedTo' => $assignedTo,
            'project' => $project,
            'statuses' => $this->statusService->getStatuesForView($this->statusService->getStatuses()),
            'priority' => $this->priorityRepository->findAll(),
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionAssign(Request $request): Response | string
    {
        $id = (int)($request->get()['id'] ?? null);

        if ($id <= 0) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = $this->tasksService->findById($id);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = $this->tasksService->update(
            $model,
            null,
            null,
            null,
            null,
            (int)$this->userService->getCurrentUser()->getId(),
        );

        return $this->renderPartial('_assigned_cell', ['model' => $model]);
    }
}
