<?php

use app\components\Statuses\Statuses;
use app\helpers\Avatars;
use app\helpers\Buttons;
use app\models\Tasks;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;

/** @var ActiveDataProvider $tasks */

$this->title = 'Моя работа';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="tasks-index">
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
                            'value' => static fn(Tasks $model): string => Avatars::getAvatarRound(
                                $model->getAuthorModel(),
                                40
                            ),
                        ],
                        [
                            'attribute' => 'assigned_to',
                            'format' => 'raw',
                            'contentOptions' => static fn(Tasks $model): array => [
                                'id' => sprintf('response-container-%s', $model->getId()),
                            ],
                            'value' => static fn(Tasks $model): string => $model->getAssignedToUserId() === null
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
                            'content' => static fn(Tasks $model): string => Buttons::getButtons(
                                $model->getPrimaryKey()
                            ),
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
