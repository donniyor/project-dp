<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\components\Avatars;
use app\components\DatesInterface;
use app\components\Statuses\Statuses;
use app\helpers\Data;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $model */
/** @var yii\widgets\ActiveForm $form */

ListAsset::register($this);

?>

<div class="container">
    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-md-9">
            <div class="task-form">
                <div class="mb-3">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="mb-3">
                    <?= Data::getTextAreaWithModel($model, 'description') ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'assigned_to')->dropDownList([], ['prompt' => 'Без исполнителя']) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'project_id')->dropDownList(
                        $model->getAllProjects(),
                        ['prompt' => '', 'class' => 'form-select']
                    ) ?>
                </div>

                <div class="mb-3">
                    <?= $form->field($model, 'status')->dropDownList(Statuses::getStatusList()) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light p-3">
                <div class="mb-3">
                    <?=
                    $form->field($model, 'status')->dropDownList(
                        Statuses::getStatusList(),
                        ['class' => 'form-control'],
                    )
                    ?>
                </div>
                <?= Html::label('Автор', 'author_id', ['class' => 'control-label']) ?>
                <div class="mb-3 rounded text-center">
                    <?= Avatars::getAvatarRound($model->getAuthorModel()) ?>
                    <h1 class="h4 font-weight-bold mt-3">
                        <?= $model->getAuthorModel()->getLastName() ?? '' ?>
                        <?= $model->getAuthorModel()->getFirstName() ?? $model->getAuthorModel()->getEmail() ?>
                    </h1>
                </div>

                <div class="mt-3 text-center">
                    <?= Html::label('Дата начала проекта', 'created_at', ['class' => 'control-label']) ?>
                    <?= $model->getCreatedAt() !== null
                        ? date(DatesInterface::DEFAULT_DATE, strtotime($model->getCreatedAt()))
                        : '' ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    ?>
</div>
