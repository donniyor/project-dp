<?php

declare(strict_types=1);

use app\assets\ListAsset;
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

    <div class="container">
        <div class="row g-2 mb-2">
            <div class="col">
                <?= Html::label('Проект') ?>
                <?= Html::dropDownList(
                    'project_id',
                    $filters['project_id'] ?? null,
                    isset($projects) ? ArrayHelper::map($projects, 'id', 'title') : [],
                    [
                        'multiple' => 'multiple',
                        'id' => 'project-id',
                        'class' => 'js-states form-control',
                        'style' => 'width: 100%',
                        'prompt' => 'Выберите проект',
                    ],
                ) ?>
            </div>

            <div class="col">
                <?= Html::label('Исполнитель') ?>
                <?= Html::dropDownList(
                    'assigned_to',
                    $filters['assigned_to'] ?? null,
                    isset($assignedToIds) ? ArrayHelper::map($assignedToIds, 'id', 'user') : [],
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

        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::a(
                'Сбросить',
                Url::to(sprintf('/%s', Yii::$app->controller->getUniqueId())),
                ['class' => 'btn btn-secondary ms-3']
            ) ?>
        </div>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
