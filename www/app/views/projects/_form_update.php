<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use app\helpers\Data;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Projects $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">
    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-md-8">
            <div class="projects-form">
                <div class="mb-3">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="mb-3">
                    <?= Data::getTextArea($model, 'description') ?>
                </div>

                <div class="form-group mb-3">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <?=
                $form->field($model, 'status')->dropDownList(
                    Statuses::getStatusList(),
                    ['class' => 'mb-3 form-control']
                )
                ?>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    ?>
</div>

