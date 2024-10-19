<?php

declare(strict_types=1);

/** @var yii\web\View $this */

/** @var app\models\Users $model */

use app\components\DatesInterface;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = 'Редактировать';

?>

<div class="user-index container">
    <div class="card shadow-b border-0 p-4">
        <?php
        $form = ActiveForm::begin(['id' => 'image-upload-form']); ?>

        <div class="row align-items-start">
            <div class="col-auto">
                <?php
                if ($model->getImageUrl()): ?>
                    <img src="<?= $model->getImageUrl() ?>"
                         alt="avatar"
                         class="img-thumbnail"
                         style="width: 200px; height: 200px; object-fit: cover;">
                <?php
                else: ?>
                    <div class="avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold"
                         style="width: 200px; height: 200px; background-color: #6c757d; font-size: 36px;">
                        <?= strtoupper(mb_substr($model->getUsername(), 0, 1)) ?>
                    </div>
                <?php
                endif; ?>

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
                <h1><?= Html::encode($this->title) ?></h1>
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

