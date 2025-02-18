<?php

declare(strict_types=1);

/** @var string $viewType */

/** @var array $boards */

use app\assets\KanbanAsset;
use app\components\Statuses\StatusesInterface;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

KanbanAsset::register($this);

?>

<div class="kanban-container">
    <div class="kanban-board">
        <?php
        foreach ($boards as $key => $board) {
            ?>
            <div class="kanban-column" data-board-id="<?= isset($board['id']) ? (int)$board['id'] : null ?>">
                <div class="kanban-header"><?= isset($board['title']) ? (string)$board['title'] : null ?></div>
                <div class="kanban-items">
                    <?php
                    if (isset($board['item'])) {
                        if ($key === StatusesInterface::STATUS_TO_DO) {
                            echo Html::a('Создать задачу', Url::to(['tasks/create']), ['class' => 'btn btn-success w-100']);
                        }
                        foreach ($board['item'] as $task) {
                            ?>
                            <div class="kanban-item d-flex align-items-start flex-column"
                                 data-id="<?= isset($task['id']) ? (string)$task['id'] : null ?>">
                                <div class="task">
                                    <?php
                                    if (isset($task['id']) && isset($task['title'])) { ?>
                                        <?= Html::a(
                                            (string)$task['title'],
                                            Url::to(['/tasks/update', 'id' => (int)$task['id']]),
                                            ['class' => 'task-title'],
                                        ) ?>
                                        <?php
                                    } ?>
                                </div>
                                <div class="d-flex justify-content-between align-items-end align-content-between w-100">
                                    <div class="kanban-assigned">
                                        <?= isset($task['assignedTo']) ? $task['assignedTo'] : '' ?>
                                    </div>
                                    <?php
                                    if (isset($task['project_id']) && isset($task['project_title'])) { ?>
                                        <?= Html::a(
                                            (string)$task['project_title'],
                                            Url::to(['/projects/update', 'id' => (int)$task['project_id']]),
                                            ['class' => 'project-title'],
                                        ) ?>
                                        <?php
                                    } ?>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
