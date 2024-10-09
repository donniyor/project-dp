<?php

use app\helpers\Buttons;
use app\models\Users;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/*
 <p>
    <?= Html::a('Добавить Пользователя', ['create'], ['class' => 'btn btn-success']) ?>
</p>
*/
$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => static fn ($model) => $model->getStatus($model->status),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'label' => 'Роли',
                'value' => function ($model) {
                    $roles = array_map(function ($role) {
                        return $role->item_name;
                    }, $model->roles);
                    return implode(', ', $roles);
                },
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn ($model) => Buttons::getUser($model)
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>


</div>