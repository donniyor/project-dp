<?php

declare(strict_types=1);

use app\components\Avatars;
use app\components\Statuses\Statuses;
use app\helpers\Buttons;
use app\models\Projects;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>
        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => ['class' => 'table table-striped table-bordered table-hover'],
                'tableOptions' => ['class' => 'table table-hover'],
                'headerRowOptions' => ['class' => 'thead-light'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'title',
                        'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 60%;'],
                    ],
                    [
                        'attribute' => 'author_search',
                        'label' => 'Автор',
                        'format' => 'raw',
                        'value' => static fn(Projects $model): string => Avatars::getAvatarRound($model->author, 50),
                        'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
                    ],
                    [
                        'attribute' => 'status',
                        'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
                        'value' => fn(Projects $model): string => Statuses::getStatusTag($model->getStatus()),
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
                        'content' => static fn(Projects $model): string => Buttons::getButtons($model->getPrimaryKey())
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
