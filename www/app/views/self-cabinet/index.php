<?php

declare(strict_types=1);

/** @var yii\web\View $this */

/** @var app\models\Users $model */

use app\components\DatesInterface;
use app\helpers\Avatars;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="user-index">
                <?php
                $form = ActiveForm::begin(['id' => 'image-upload-form']); ?>

                <div class="row align-items-start">
                    <div class="col-auto">
                        <?= Avatars::getAvatarSquare($model) ?>

                        <div class="mt-3">
                            <div class="mt-3">
                                <?= $form->field($model, 'image_url')->fileInput([
                                    'style' => 'width: 200px; padding: 0.375rem 0.75rem; background-color: #e9ecef; border: 1px solid #ced4da; border-radius: 0.25rem;',
                                    'class' => 'form-control form-control-sm',
                                ])->label(false) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="row">
                            <div class="col-lg">
                                <div class="mb-3">
                                    <?= $form->field($model, 'first_name')->textInput([
                                        'value' => $model->getFirstName(),
                                        'placeholder' => 'Поле не заполнено'
                                    ]) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $form->field($model, 'last_name')->textInput([
                                        'value' => $model->getLastName(),
                                        'placeholder' => 'Поле не заполнено'
                                    ]) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $form->field($model, 'department')->textInput([
                                        'value' => $model->getDepartment(),
                                        'placeholder' => 'Поле не заполнено'
                                    ]) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $form->field($model, 'position')->textInput([
                                        'value' => $model->getPosition(),
                                        'placeholder' => 'Поле не заполнено'
                                    ]) ?>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-sm']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                ActiveForm::end(); ?>
                <div class="card-footer text-start bg-light mt-3">
                    <small class="text-muted">
                        Последнее обновление: <?= date(DatesInterface::DEFAULT_DATE, $model->getCreatedAt()) ?>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

