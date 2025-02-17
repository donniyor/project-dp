<?php

declare(strict_types=1);

/** @var string $viewType */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var array $filters */

use app\assets\KanbanAsset;

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

KanbanAsset::register($this);

?>

<div class="kanban-container">
    <div class="kanban-board">
        <div class="kanban-column" data-board-id="backlog">
            <div class="kanban-header">Backlog</div>
            <div class="kanban-items">
                <div class="kanban-item" data-id="task-a">
                    <a href="#task-a">Task A</a>
                </div>
                <div class="kanban-item" data-id="task-b">
                    <a href="#task-b">Task B</a>
                </div>
            </div>
        </div>

        <div class="kanban-column" data-board-id="todo">
            <div class="kanban-header">To Do</div>
            <div class="kanban-items">
                <div class="kanban-item" data-id="task-1">
                    <a href="#task-1">Task 1</a>
                </div>
                <div class="kanban-item" data-id="task-2">
                    <a href="#task-2">Task 2</a>
                </div>
            </div>
        </div>

        <div class="kanban-column" data-board-id="in-progress">
            <div class="kanban-header">In Progress</div>
            <div class="kanban-items">
                <div class="kanban-item" data-id="task-3">
                    <a href="#task-3">Task 3</a>
                </div>
            </div>
        </div>

        <div class="kanban-column" data-board-id="review">
            <div class="kanban-header">Review</div>
            <div class="kanban-items">
                <div class="kanban-item" data-id="task-4">
                    <a href="#task-4">Task 4</a>
                </div>
            </div>
        </div>

        <div class="kanban-column" data-board-id="done">
            <div class="kanban-header">Done</div>
            <div class="kanban-items">
                <div class="kanban-item" data-id="task-5">
                    <a href="#task-5">Task 5</a>
                </div>
            </div>
        </div>
    </div>
</div>
