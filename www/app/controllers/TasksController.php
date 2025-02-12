<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\TaskCreateDTO;
use app\DTO\TaskSearchDTO;
use app\models\Tasks;
use app\models\Users;
use app\Service\ProjectService;
use app\Service\TaskService;
use app\Service\UserService;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Cookie;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class TasksController extends BaseController
{
    private TaskService $tasksService;
    private UserService $userService;
    private ProjectService $projectService;

    public function __construct(
        $id,
        $module,
        TaskService $tasksService,
        UserService $userService,
        ProjectService $projectService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);

        $this->tasksService = $tasksService;
        $this->userService = $userService;
        $this->projectService = $projectService;
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
     * @throws BadRequestHttpException
     */
    public function actionSetViewType(string $type): Response
    {
        if (!in_array($type, ['kanban', 'table'], true)) {
            throw new BadRequestHttpException('Invalid view type.');
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'viewType',
            'value' => $type,
            'expire' => time() + 3600 * 24 * 30,
        ]));

        return $this->redirect(['index']);
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate(Request $request): Response | string
    {
        $post = $request->post();
        $data = TaskCreateDTO::fromArray($post);

        if ($request->getIsPost()) {
            $model = $this->tasksService->create();
            dd('a');

            $this->redirect(['update', 'id' => $model->getId()]);
        }

        return $this->render('create');
    }

    /**
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionUpdate(int $id): string
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
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


    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Tasks
    {
        if (($model = Tasks::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
