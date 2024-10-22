<?php

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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        $model->getAllUsers(),
        [
            'id' => 'user-dropdown',
            'prompt' => 'Не назначено',
            'options' => array_map(function ($value) {
                return [
                    'data-content' => $value,
                    'class' => 'custom-option'
                ];
            }, $model->getAllUsers())
        ]
    ) ?>

    <?= $form->field($model, 'assigned_to') ?>

    <?php
    // echo $form->field($model, 'status') ?>

    <?php
    // echo $form->field($model, 'created_at') ?>

    <?php
    // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Сбросить',
            Url::to(''),
            ['class' => 'btn btn-outline-secondary']
        ) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
