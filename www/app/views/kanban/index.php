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
<div class="tasks-index">
    <div class="tasks-index">
        <h1>Задачи</h1>
        <hr>
        <div style="overflow-x: auto; white-space: nowrap;">
            <div id="kanban-tasks"></div>
        </div>
    </div>
</div>
