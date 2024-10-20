<?php

declare(strict_types=1);

use app\components\Avatars;
use app\components\Statuses\Statuses;
use app\components\Statuses\StatusesInterface;
use app\models\Projects;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ProjectsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="projects-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
                        'value' => fn(Projects $model): string => Html::tag(
                            'span',
                            Statuses::getStatusName($model->getStatus()),
                            [
                                'class' => 'badge ' . ($model->getStatus(
                                    ) === StatusesInterface::STATUS_ACTIVE ? 'bg-success' : 'bg-danger') . ' p-2',
                            ]
                        ),
                        'format' => 'raw',
                        'filter' => Html::activeDropDownList($searchModel, 'status', [
                            '' => 'Все',
                            StatusesInterface::STATUS_ACTIVE => 'Активный',
                            StatusesInterface::STATUS_DELETED => 'Неактивный',
                        ], ['class' => 'form-control']),
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
