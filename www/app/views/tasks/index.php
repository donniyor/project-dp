<?php

declare(strict_types=1);

use app\components\Avatars;
use app\components\Statuses\Statuses;
use app\helpers\Buttons;
use app\models\Tasks;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'class' => 'table-responsive'
        ],
        'tableOptions' => [
            'class' => 'table border-bottom'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'author_id',
                'format' => 'raw',
                'value' => static fn(Tasks $model): string => Avatars::getAvatarRound(
                    $model->getAuthorModel(),
                    40
                ),
                'headerOptions' => ['class' => 'text-nowrap text-center'],
                'contentOptions' => ['class' => 'text-center'],
            ],
            [
                'attribute' => 'assigned_to',
                'format' => 'raw',
                'headerOptions' => ['class' => 'text-nowrap text-center'],
                'contentOptions' => ['class' => 'text-center text-decoration-none d-flex flex-column align-items-center justify-content-center'],
                'value' => static fn(Tasks $model): string => Avatars::getAvatarRound(
                    $model->getAssignedToModel(),
                    40
                ),
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['class' => 'text-nowrap text-center', 'style' => 'width: 20%;'],
                'contentOptions' => ['class' => 'text-center'],
                'value' => fn(Tasks $model): string => Statuses::getStatusTag($model->getStatus()),
                'format' => 'raw',
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center', 'width' => '150'],
                'content' => static fn(Tasks $model): string => Buttons::getButtons($model->getPrimaryKey())
            ],
        ],
    ]); ?>


</div>
