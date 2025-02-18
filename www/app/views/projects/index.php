<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use app\helpers\Avatars;
use app\helpers\Buttons;
use app\models\Projects;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/** @var View $this */
/** @var ActiveDataProvider $projects */
/** @var array $filters */
/** @var null|array $users */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="projects-index">
                <?= $this->render('_search', ['filters' => $filters, 'users' => $users]); ?>
                <p>
                    <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
                </p>

                <div class="table-responsive">
                    <div class="table-responsive">
                        <?= GridView::widget([
                            'dataProvider' => $projects,
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
                                    'attribute' => 'author_id',
                                    'format' => 'raw',
                                    'value' => static fn(Projects $model): string => Avatars::getAvatarRound(
                                        $model->getAuthorModel(),
                                        50,
                                    ),
                                    'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'headerOptions' => ['class' => 'text-nowrap', 'style' => 'width: 20%;'],
                                    'value' => fn(Projects $model): string => Statuses::getStatusTag(
                                        $model->getStatus()
                                    ),
                                    'format' => 'raw',
                                ],
                                [
                                    'header' => 'Действия',
                                    'format' => 'html',
                                    'headerOptions' => ['width' => '150'],
                                    'content' => static fn(Projects $model): string => Buttons::getButtons(
                                        $model->getPrimaryKey()
                                    ),
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
