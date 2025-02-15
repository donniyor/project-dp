<?php

declare(strict_types=1);

use app\helpers\Avatars;
use app\helpers\Buttons;
use app\models\AuthAssignment;
use app\models\Users;
use yii\grid\GridView;
use yii\helpers\Html;

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
            [
                'label' => 'Пользователь',
                'format' => 'raw',
                'value' => static fn(Users $model): string => Avatars::getAvatarRound(
                    $model,
                    50
                ),
                'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
            ],
            'first_name',
            'last_name',
            'email:email',
            [
                'label' => 'Роли',
                'value' => fn(Users $model): string => implode(
                    ', ',
                    array_map(fn(AuthAssignment $role): string => $role->getItemName(), $model->getRoleModel())
                ),
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
