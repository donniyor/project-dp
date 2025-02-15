<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\components\Statuses\Statuses;
use app\components\Statuses\StatusesInterface;
use app\helpers\Data;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/** @var View $this */
/** @var ActiveForm $form */

ListAsset::register($this);

?>

<div class="tasks-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= Html::label('Название') ?>
        <?= Html::textInput('title', '', ['maxlength' => true, 'class' => 'form-control']) ?>    </div>

    <div class="mb-3">
        <?= Html::label('Описание') ?>
        <?= Data::getTextArea('description', '') ?>
    </div>

    <div class="mb-3">
        <?= Html::label('Исполнитель') ?>
        <?= Html::dropDownList(
            'assigned_to',
            null,
            [],
            [
                'id' => 'assigned-to',
                'class' => 'js-states form-control',
                'tabindex' => '-1',
                'style' => 'display: none; width: 100%',
                'prompt' => 'Выберите исполнителя',
            ],
        ) ?>
    </div>

    <div class="mb-3">
        <?= Html::label('Проект') ?>
        <?= Html::dropDownList(
            'project_id',
            null,
            [],
            [
                'id' => 'project-id',
                'class' => 'js-states form-control',
                'style' => 'width: 100%',
                'prompt' => 'Выберите проект',
            ],
        ) ?>
    </div>

    <div class="mb-3">
        <?= Html::label('Статус') ?>
        <?=
        Html::dropDownList(
            'status',
            null,
            [],
            [
                'id' => 'status-id',
                'class' => 'js-states form-control',
                'style' => 'width: 100%',
                'prompt' => 'Выберите статус',
            ],
        )
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
