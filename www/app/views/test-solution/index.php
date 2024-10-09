<?php

use app\helpers\Buttons;
use app\models\TestSolution;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\QuizizzSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Результаты опросов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-solution-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => static fn($model) => $model->giveStatus($model->status),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            [
                'label' => 'Автор',
                'value' => 'user.username',
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn($model) => Buttons::getView($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>


</div>
