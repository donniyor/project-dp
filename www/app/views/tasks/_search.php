<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\components\Statuses\Statuses;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var ActiveForm $form */
/** @var array $filters */
/** @var null|array $authors */
/** @var null|array $assignedTo */

ListAsset::register($this);

?>

<div class="tasks-search">
    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <div class="mb-3">
                    <?= Html::label('Проект') ?>
                    <?= Html::dropDownList(
                        'project_id',
                        $filters['project_id'] ?? null,
                        [],
                        [
                            'id' => 'project-id',
                            'class' => 'js-states form-control',
                            'style' => 'width: 100%',
                            'prompt' => 'Выберите проект',
                        ],
                    ) ?>
                </div>
            </div>

            <div class="mb-3">
                <?= Html::label('Автор') ?>
                <?= Html::dropDownList(
                    'author_id',
                    $filters['author_id'] ?? null,
                    isset($authors) ? ArrayHelper::map($authors, 'id', 'user') : [],
                    [
                        'multiple' => 'multiple',
                        'id' => 'author-id',
                        'class' => 'js-states form-control',
                        'tabindex' => '-1',
                        'style' => 'display: none; width: 100%',
                        'prompt' => 'Выберите автора',
                    ],
                ) ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <?= Html::label('Статус') ?>
                <?= Html::dropDownList(
                    'status',
                    $filters['status'] ?? null,
                    Statuses::getStatusList(),
                    ['class' => 'form-control', 'prompt' => '']
                ) ?>
            </div>

            <?= Html::label('Исполнитель') ?>
            <?= Html::dropDownList(
                'assigned_to',
                $filters['assigned_to'] ?? null,
                isset($assignedTo) ? ArrayHelper::map($assignedTo, 'id', 'user') : [],
                [
                    'multiple' => 'multiple',
                    'id' => 'assigned-to',
                    'class' => 'js-states form-control',
                    'tabindex' => '-1',
                    'style' => 'display: none; width: 100%',
                    'prompt' => 'Выберите исполнителя',
                ],
            ) ?>
        </div>
    </div>

    <div class="form-group mb-5">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Сбросить',
            Url::to(sprintf('/%s', Yii::$app->controller->getUniqueId())),
            ['class' => 'btn btn-secondary ms-3']
        ) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
