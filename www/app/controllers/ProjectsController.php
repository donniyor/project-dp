<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\DTO\ProjectSearchDTO;
use app\models\Projects;
use app\Service\ProjectService;
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

    public function __construct(
        string $id,
        Module $module,
        ProjectService $projectService,
        UserService $userService,
    ) {
        parent::__construct($id, $module);

        $this->projectService = $projectService;
        $this->userService = $userService;
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
        $filters = $this->request->get();
        $params = ProjectSearchDTO::fromArray($filters);
        $projects = $this->projectService->search($params);
        $users = null;
        if ($params->getAuthorIds() !== null) {
            $users = $this->userService->getUsersForView($params->getAuthorIds());
        }

        return $this->render('index', [
            'filters' => $filters,
            'projects' => $projects,
            'users' => $users,
        ]);
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionCreate(): Response | string
    {
        $model = new Projects();

        if ($this->request->isPost) {
            $this->saveData($model, 'update');

            $this->redirect(['update', 'id' => $model->getId()]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    public function actionUpdate(int $id): string
    {
        $model = $this->findModel($id);

        if ($model->getAuthorModel()->getId() !== Yii::$app->getUser()->getId()) {
            return $this->render('view', ['model' => $model]);
        }

        if ($this->request->isPost) {
            $this->saveData($model, 'update');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Projects
    {
        if (($model = Projects::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
