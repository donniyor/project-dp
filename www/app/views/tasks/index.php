<?php

declare(strict_types=1);

/** @var string $viewType */
/** @var yii\data\ActiveDataProvider $dataProvider */

/** @var app\models\TasksSearch $searchModel */

use yii\helpers\Html;

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tasks-index">
    <div class="view-toggle">
        <?= Html::a('Kanban', ['set-view-type', 'type' => 'kanban'], [
            'class' => $viewType === 'kanban' ? 'btn btn-primary' : 'btn btn-default',
        ]) ?>
        <?= Html::a('Table', ['set-view-type', 'type' => 'table'], [
            'class' => $viewType === 'table' ? 'btn btn-primary' : 'btn btn-default',
        ]) ?>
    </div>
    <hr>
    <?= $viewType === 'kanban'
        ? $this->render('_kanban')
        : $this->render('_table', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]) ?>
</div>
