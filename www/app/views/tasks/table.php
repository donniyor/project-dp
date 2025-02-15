<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use app\helpers\Avatars;
use app\helpers\Buttons;
use app\models\Tasks;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $tasks */
/** @var array $filters */
/** @var null|array $authors */
/** @var null|array $assignedTo */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <p>
        <?= Html::a('Создать задачу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $this->render(
        '_search',
        [
            'filters' => $filters ?? null,
            'authors' => $authors ?? null,
            'assignedTo' => $assignedTo ?? null,
        ],
    ); ?>

    <?= GridView::widget([
        'dataProvider' => $tasks,
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
            ],
            [
                'attribute' => 'project_id',
                'value' => 'project.title',
            ],
            [
                'attribute' => 'author_id',
                'format' => 'raw',
                'value' => static fn(Tasks $model): string => Avatars::getAvatarRound($model->getAuthorModel(), 40),
            ],
            [
                'attribute' => 'assigned_to',
                'format' => 'raw',
                'contentOptions' => static fn(Tasks $model): array => [
                    'id' => sprintf('response-container-%s', $model->getId()),
                ],
                'value' => static fn(Tasks $model): string => $model->getAssignedToUser() === null
                    ? Avatars::getAssignedToButton($model->getId(), 40)
                    : ($model->getAssignedToModel() === null
                        ? Avatars::getAssignedToButton($model->getId(), 40)
                        : Avatars::getAvatarRound($model->getAssignedToModel(), 40)
                    ),
            ],
            [
                'attribute' => 'status',
                'value' => fn(Tasks $model): string => Statuses::getStatusTag($model->getStatus()),
                'format' => 'raw',
            ],
            [
                'header' => 'Действия',
                'format' => 'html',
                'headerOptions' => ['width' => '150'],
                'content' => static fn(Tasks $model): string => Buttons::getButtons($model->getPrimaryKey()),
            ],
        ],
    ]); ?>
</div>
