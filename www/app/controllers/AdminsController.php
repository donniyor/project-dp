<?php

namespace app\controllers;

use app\components\BaseBehaviors;
use app\components\RolesInterface;
use app\models\CreateAdminForm;
use app\models\Users;
use app\models\UsersSearch;
use Yii;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Users model.
 */
class AdminsController extends Controller
{
    public function behaviors(): array
    {
        return BaseBehaviors::getBehaviors([RolesInterface::SUPER_ADMIN_ROLE]);
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'create' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CreateAdminForm();


        if ($model->load(Yii::$app->request->post())) {
            $model->createUser();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $user = $this->findModel($id);
        $user->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
