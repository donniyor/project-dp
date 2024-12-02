<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\BaseController;
use app\components\Statuses\Statuses;
use app\models\Tasks;
use Yii;
use yii\db\Exception;
use yii\web\Request;
use yii\web\Response;

class ApiTasksController extends BaseController
{
    public function actionData(): Response
    {
        $tasks = Tasks::find()->all();
        $boards = [];

        foreach (Statuses::getStatuses() as $status) {
            $boards[(string)$status] = [
                'id' => (string)$status,
                'title' => Statuses::getStatusName($status),
                'class' => 'success',
                'item' => []
            ];
        }

        /** @var Tasks $task */
        foreach ($tasks as $task) {
            $boards[(string)$task->getStatus()]['item'][] = [
                'id' => (string)$task->getId(),
                'title' => $task->getTitle(),
            ];
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->asJson($boards);
    }

    /**
     * @throws Exception
     */
    public function actionUpdateStatus(Request $request): Response
    {
        $taskId = (int)$request->post('taskId');
        $status = (int)$request->post('status');
        $task = Tasks::findOne($taskId);

        if ($task !== null) {
            $task->status = $status;
            if ($task->save()) {
                return $this->asJson(['status' => 'success']);
            }

            return $this->asJson(['status' => 'error', 'message' => 'Не удалось обновить статус задачи']);
        }

        return $this->asJson(['status' => 'error', 'message' => 'Задача не найдена']);
    }

}
