<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\ProjectCreateDTO;
use app\DTO\ProjectSearchDTO;
use app\DTO\ProjectUpdateRequest;
use app\Service\ProjectService;
use app\Service\StatusService;
use app\Service\UserService;
use Yii;
use yii\base\Exception;
use yii\base\Module;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends BaseController
{
    private ProjectService $projectService;
    private UserService $userService;
    private StatusService $statusService;

    public function __construct(
        string $id,
        Module $module,
        ProjectService $projectService,
        UserService $userService,
        StatusService $statusService,
    ) {
        parent::__construct($id, $module);

        $this->projectService = $projectService;
        $this->userService = $userService;
        $this->statusService = $statusService;
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(Request $request): string
    {
        $params = $request->get();
        $params = ProjectSearchDTO::fromArray($params);

        $projects = $this->projectService->search(
            $params->getStatus(),
            $params->getAuthorIds(),
        );

        $users = null;
        if ($params->getAuthorIds() !== null) {
            $users = $this->userService->getUsersForView(
                $this->userService->findByIds($params->getAuthorIds()),
            );
        }

        return $this->render('index', [
            'filters' => $params->toArray(),
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(Request $request): string
    {
        $post = $request->post();
        $data = ProjectCreateDTO::fromArray($post);

        if ($request->getIsPost()) {
            $model = $this->projectService->create(
                $data->getTitle(),
                $data->getDescription(),
                $data->getStatus(),
                $this->userService->getCurrentUser()->getId(),
            );

            $this->redirect(['update', 'id' => $model->getId()]);
        }

        return $this->render('create');
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionUpdate(int $id, Request $request): string
    {
        $model = $this->projectService->findById($id);
        $statuses = $this->statusService->getStatuesForView(
            $this->statusService->getStatuses(),
        );

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $data = $model->toArray();
        if ($request->getIsPost() && $request->validateCsrfToken()) {
            // todo add validation
            $data = ProjectUpdateRequest::fromArray($request->post());
            $this->projectService->updateOne(
                $data->title,
                $data->description,
                $data->status,
            );
            $data = $data->toArray();
        }

        return $this->render('update', [
            'data' => $data,
            'model' => $model,
            'statuses' => $statuses,
        ]);
    }

    public function actionGetProjects(Request $request): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $title = (string)$request->get('query');
        $limit = (int)$request->get('limit', 10);

        if (!empty($title) && $limit > 0) {
            return $this->projectService->processProjects(
                $this->projectService
                    ->searchByTitle($title, $limit),
            );
        }

        return $this->projectService->processProjects(
            $this->projectService
                ->findBy(5),
        );
    }
}
