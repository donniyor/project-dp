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
                            echo Html::a(
                                'Создать задачу',
                                Url::to(['tasks/create']),
                                ['class' => 'btn btn-success w-100 create-task-btn'],
                            );
                        }
                        foreach ($board['item'] as $task) {
                            ?>
                            <div class="kanban-item d-flex align-items-start flex-column"
                                 data-id="<?= isset($task['id']) ? (string)$task['id'] : null ?>">

                                <!-- Верхняя часть: Приоритет, Название, Дедлайн -->
                                <div class="d-flex w-100 align-items-start">
                                    <!-- Левая часть (приоритет + название) -->
                                    <div class="d-flex flex-grow-1">
                                        <div class="material-icons task-icon"
                                             style="color: <?= isset($task['color']) ? $task['color'] . ' !important' : '' ?>; margin-right: 8px;">
                                            <?= $task['priority'] ?? '' ?>
                                        </div>
                                        <div class="task">
                                            <?= isset($task['id']) && isset($task['title'])
                                                ? Html::a(
                                                    (string)$task['title'],
                                                    Url::to(['/tasks/update', 'id' => (int)$task['id']]),
                                                    ['class' => 'task-title'],
                                                )
                                                : ''
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Правая часть (дедлайн) -->
                                    <div class="task-deadline">
                                        <?= isset($task['deadline'])
                                            ? Yii::$app->formatter->asDate($task['deadline'], 'php:d-m-Y')
                                            : '' ?>
                                    </div>
                                </div>

                                <!-- Нижняя часть: Исполнитель + Проект -->
                                <div class="d-flex justify-content-between align-items-end w-100">
                                    <div class="kanban-assigned">
                                        <?= isset($task['assignedTo']) ? $task['assignedTo'] : '' ?>
                                    </div>

                                    <?php if (isset($task['project_id']) && isset($task['project_title'])) { ?>
                                        <?= Html::a(
                                            (string)$task['project_title'],
                                            Url::to(['/projects/update', 'id' => (int)$task['project_id']]),
                                            ['class' => 'project-title'],
                                        ) ?>
                                    <?php } ?>
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
