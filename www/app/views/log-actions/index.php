<?php

use app\models\LogActions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LogActionsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Журнал Событий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-actions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'admin_login',
            'action_type',
            'extra:html',
            [
                'label' => 'Дата запроса',
                'value' => 'created_at'
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>
</div>
