<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\TaskCreateDTO;
use app\DTO\TaskSearchDTO;
use app\models\Users;
use app\Service\TaskService;
use app\Service\UserService;
use app\Validator\TaskValidator;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class TasksController extends BaseController
{
    private TaskService $tasksService;
    private UserService $userService;
    private TaskValidator $validator;

    public function __construct(
        $id,
        $module,
        TaskService $tasksService,
        UserService $userService,
        TaskValidator $validator,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->tasksService = $tasksService;
        $this->userService = $userService;
        $this->validator = $validator;
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

    public function actionCreate(Request $request): Response | string
    {
        if ($request->getIsGet()) {
            return $this->render('create');
        }

        $data = $request->post();
        $errors = $this->validator->validate($data);
        if ($errors !== null) {
            $this->makeError($errors);

            return $this->render('create');
        }

        $data = TaskCreateDTO::fromArray($data);

        $model = $this->tasksService->create(
            $data->getTitle(),
            $data->getDescription(),
            $data->getStatus(),
            $data->getProjectId(),
            $this->userService->getCurrentUser()->getId(),
            $data->getAssignedTo(),
        );

        $errors = $model->getErrors();
        if (!empty($errors)) {
            $this->makeError($errors);

            return $this->render('create');
        }

        return $this->redirect(['update', 'id' => $model->getId()]);
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
            $this->saveData($model);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionAssign(int $id): Response | string
    {
        $model = $this->findModel($id);
        $model->setAssignedTo((int)Yii::$app->getUser()->getId());

        if ($model->validate() && $model->save() && Yii::$app->request->isAjax) {
            return $this->renderPartial('_assigned_cell', ['model' => $model]);
        }

        return $this->back();
    }
}
