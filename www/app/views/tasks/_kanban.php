<?php

declare(strict_types=1);

use app\assets\KanbanAsset;

KanbanAsset::register($this);

?>

<div class="tasks-index">
    <h1>Задачи</h1>
    <div style="overflow-x: auto; white-space: nowrap;">
        <div id="myKanban"></div>
    </div>
</div>