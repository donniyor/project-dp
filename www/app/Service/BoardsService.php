<?php

declare(strict_types=1);

namespace app\Service;

use app\helpers\Avatars;
use app\models\Tasks;
use yii\helpers\Url;

class BoardsService
{
    public function getBoards(array $statuses, array $tasks): array
    {
        $boards = [];
        foreach ($statuses as $key => $status) {
            $boards[(string)$key] = [
                'id' => (string)$key,
                'title' => $status,
                'class' => 'success',
                'item' => []
            ];
        }

        /** @var Tasks $task */
        foreach ($tasks as $task) {
            if (isset($boards[(string)$task->getStatus()])) {
                $boards[(string)$task->getStatus()]['item'][] = [
                    'id' => (string)$task->getId(),
                    'title' => $task->getTitle(),
                    'url' => Url::to([sprintf('/tasks/update/%s', $task->getId())]),
                    'assignedTo' => $task->getAssignedToUserId() === null
                        ? Avatars::getAssignedToButton($task->getId(), 30)
                        : (
                        $task->getAssignedToModel() === null
                            ? Avatars::getAssignedToButton($task->getId(), 30)
                            : Avatars::getAvatarRound($task->getAssignedToModel(), 30, false)
                        )
                ];
            }
        }

        return $boards;
    }
}