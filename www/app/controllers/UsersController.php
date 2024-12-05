<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\Avatars;
use app\models\CreateAdminForm;
use app\models\Users;
use app\models\UsersSearch;
use Exception;
use Throwable;
use app\components\BaseController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\Response;

class UsersController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(Request $request): Response | string
    {
        $model = new CreateAdminForm();

        if ($model->load($request->post())) {
            if (!$model->createUser()) {
                $this->flash('danger', 'Ошибка: ' . $this->formatErrors($model));

                return $this->back();
            } else {
                $this->flash('success', 'Пользователь был создан');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionDetail(int $id): string
    {
        $model = $this->findModel($id);

        return $this->render('detail', ['model' => $model]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete(int $id): Response
    {
        $user = $this->findModel($id);

        try {
            $user->delete();
        } catch (Throwable $e) {
            $this->flash('danger', 'Ошибка: ' . $this->formatErrors($user));

            return $this->back();
        }

        return $this->redirect(['index']);
    }

    public function actionGetUsers(Request $request): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = $request->get('query', null);
        $limit = $request->get('limit', 3);
        $usersQuery = Users::find()
            ->select(['id', 'username', 'first_name', 'last_name']);

        if ($query !== null) {
            $query = strtolower($query);
            $usersQuery->where(['like', 'LOWER(username)', $query])
                ->orWhere(['like', 'LOWER(first_name)', $query])
                ->orWhere(['like', 'LOWER(last_name)', $query]);
        }

        $users = $usersQuery->limit($limit)->all();
        $result = [];

        /** @var Users $user */
        foreach ($users as $user) {
            $avatarHtml = Avatars::getAvatarRound($user, 30, false);
            $result[] = [
                'id' => $user->getId(),
                'user' => sprintf('%s %s', $user->getLastName(), $user->getFirstName()),
                'avatar' => $avatarHtml,
            ];
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Users
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Users
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
