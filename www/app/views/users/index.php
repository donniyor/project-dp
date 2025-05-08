<?php

declare(strict_types=1);

use app\helpers\Avatars;
use app\models\AuthAssignment;
use app\models\Users;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="user-index">
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
                            'label' => 'Пользователь',
                            'format' => 'raw',
                            'value' => static fn(Users $model): string => Avatars::getAvatarRound(
                                $model,
                                40,
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
                                array_map(fn(AuthAssignment $role): string => $role->getItemName(),
                                    $model->getRoleModel())
                            ),
                        ],
                    ],
                    'pager' => [
                        'class' => '\yii\bootstrap5\LinkPager',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
