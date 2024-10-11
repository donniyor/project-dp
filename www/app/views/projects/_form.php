<?php

declare(strict_types=1);

use app\components\BaseModel;
use app\helpers\Data;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Projects $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="projects-form">
    <?php
    $form = ActiveForm::begin();
    ?>

    <hr>
    <div class="mt-3">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mt-3">
        <?= Data::getTextArea($model, 'description') ?>
    </div>

    <div class="mt-3">
        <?=
        $form->field($model, 'status')->dropDownList(
            BaseModel::getStatusList(),
            ['class' => 'mb-3 form-control']
        )
        ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end();
    ?>

</div>
