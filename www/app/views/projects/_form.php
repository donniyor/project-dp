<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use app\components\Statuses\StatusesInterface;
use app\helpers\Data;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="projects-form">
    <?php
    $form = ActiveForm::begin();
    ?>

    <hr>
    <div class="mt-3">
        <?= Html::label('Название проекта') ?>
        <?= Html::textInput('title', '', ['maxlength' => true, 'class' => 'form-control']) ?>
    </div>

    <div class="mt-3">
        <?= Html::label('Описание') ?>
        <?= Data::getTextArea('description', '') ?>
    </div>

    <div class="mt-3">
        <?= Html::label('Статус') ?>
        <?=
        Html::dropDownList(
            'status',
            StatusesInterface::STATUS_TO_DO,
            Statuses::getStatusList(),
            ['class' => 'form-control', 'prompt' => ''],
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
