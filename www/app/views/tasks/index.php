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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'author_id',
                'format' => 'raw',
                'value' => static fn(Tasks $model): string => Avatars::getAvatarRound(
                    $model->getAuthorModel(),
                    40
                ),
            ],
            [
                'attribute' => 'assigned_to',
                'format' => 'raw',
                'value' => static fn(Tasks $model): string => Avatars::getAvatarRound(
                    $model->getAuthorModel(),
                    40
                ),
            ],
            [
                'attribute' => 'status',
                'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
                'value' => fn(Tasks $model): string => Statuses::getStatusTag($model->getStatus()),
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    array_merge(['' => 'Все'], Statuses::getStatusList()),
                    ['class' => 'form-control']
                ),
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn(Tasks $model): string => Buttons::getButtons($model->getPrimaryKey())
            ],
        ],
    ]); ?>


</div>
