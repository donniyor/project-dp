<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tasks-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'assigned_to')->dropDownList($model->getAllUsers(), ['prompt' => 'Не назначено']) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'project_id')->dropDownList($model->getAllProjects()) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'status')->dropDownList(Statuses::getStatusList()) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
