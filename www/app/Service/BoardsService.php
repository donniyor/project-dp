<?php

declare(strict_types=1);

namespace app\Service;

use app\helpers\Avatars;
use app\models\Tasks;
use app\Repository\PriorityRepository;
use yii\helpers\Url;

class BoardsService
{
    private PriorityRepository $priorityRepository;

    public function __construct(PriorityRepository $priorityRepository)
    {
        $this->priorityRepository = $priorityRepository;
    }

    public function getBoards(array $statuses, array $tasks, int $avatarSize = 30): array
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
                        ? Avatars::getAssignedToButton($task->getId(), $avatarSize)
                        : (
                        $task->getAssignedToModel() === null
                            ? Avatars::getAssignedToButton($task->getId(), $avatarSize)
                            : Avatars::getAvatarRound($task->getAssignedToModel(), $avatarSize, false)
                        ),
                    'project_title' => $task->project->getTitle(),
                    'project_id' => $task->getProjectId(),
                    'priority' => $this->priorityRepository->findIcon($task->getPriority()),
                    'color' => $this->priorityRepository->findColor($task->getPriority()),
                    'deadline' => $task->getDeadLine(),
                    'deadline-color' => $this->getDeadlineClass($task->getDeadLine()),
                ];
            }
        }

        return $boards;
    }

    public function getDeadlineClass(string $deadline): string
    {
        if (!$deadline) {
            return '';
        }

        $deadline = strtotime($deadline);
        $today = strtotime(date('Y-m-d'));
        $daysLeft = ceil(($deadline - $today) / (60 * 60 * 24));

        return match (true) {
            $daysLeft <= 0 => 'deadline-past',
            $daysLeft <= 3 => 'deadline-warning',
            $daysLeft <= 7 => 'deadline-soon',
            default => 'deadline-normal',
        };
    }
}