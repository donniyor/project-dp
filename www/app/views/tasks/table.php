<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use app\helpers\Avatars;
use app\helpers\Buttons;
use app\helpers\PriorityHelper;
use app\models\Tasks;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $tasks */
/** @var array $filters */
/** @var null|array $authors */
/** @var null|array $assignedTo */

$this->title = 'Беклог';
$this->title = 'Беклог';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="tasks-index">
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
                            'contentOptions' => ['class' => 'task-title'],
                        ],
                        [
                            'attribute' => 'project_id',
                            'value' => static fn(Tasks $model): string => Html::a(
                                null === $model->getProjectModel()
                                    ? 'Нет проекта'
                                    : $model->getProjectModel()->getTitle(),
                                [
                                    null === $model->getProjectModel()
                                        ? ''
                                        : sprintf(
                                        '/projects/update/%s',
                                        $model->getProjectId(),
                                    ),
                                ],
                            ),
                            'format' => 'html',
                            'contentOptions' => ['class' => 'project-title'],
                        ],
                        [
                            'attribute' => 'status',
                            'value' => fn(Tasks $model): string => Statuses::getStatusTag($model->getStatus()),
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'priority',
                            'value' => fn(Tasks $model): string => PriorityHelper::getPriorityById(
                                $model->getPriority()
                            ),
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'deadline',
                            'format' => 'raw',
                            'value' => 'deadline',
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
                            'header' => 'Действия',
                            'format' => 'html',
                            'headerOptions' => ['width' => '150'],
                            'content' => static fn(Tasks $model): string => Buttons::getButtons(
                                $model->getPrimaryKey(),
                                'tasks',
                            ),
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>