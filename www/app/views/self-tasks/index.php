<?php

declare(strict_types=1);

/** @var string $viewType */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= TasksView::getTasks($dataProvider) ?>
</div>
