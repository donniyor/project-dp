<?php

declare(strict_types=1);

use app\components\Tasks\TasksView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\TasksSearch $searchModel */

?>

<div class="tasks-table">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= TasksView::getTasks($dataProvider) ?>
</div>
