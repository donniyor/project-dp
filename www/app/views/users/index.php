<?php

declare(strict_types=1);

use app\helpers\Buttons;
use app\models\Users;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user;

?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>
        <?= Html::a('Добавить Пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => [],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'label' => 'Роли',
                'value' => function (Users $model) {
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
                'content' => static fn(Users $model): string => Buttons::getUser($model->getPrimaryKey())
            ],
        ],
        'pager' => [
            'class' => '\yii\bootstrap5\LinkPager',
        ],
    ]); ?>

</div>
