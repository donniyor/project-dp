<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="tasks-search">
    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="mb-3">
        <?= $form->field($model, 'title') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'assigned_to')
            ->dropDownList(
                $model->getAllUsers(),
                [
                    'multiple' => 'multiple',
                    'id' => 'assigned-to',
                    'class' => 'js-states form-control',
                    'tabindex' => '-1',
                    'style' => 'display: none; width: 100%'
                ]
            ) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'author_id')
            ->dropDownList(
                $model->getAllUsers(),
                [
                    'multiple' => 'multiple',
                    'id' => 'author-id',
                    'class' => 'js-states form-control',
                    'tabindex' => '-1',
                    'style' => 'display: none; width: 100%'
                ]
            ) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'status')->dropDownList(Statuses::getStatusList(), ['prompt' => '']) ?>
    </div>

    <div class="form-group mb-5">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Сбросить',
            Url::to(sprintf('/%s', Yii::$app->controller->getUniqueId())),
            ['class' => 'btn btn-outline-secondary']
        ) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
