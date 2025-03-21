<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var CreateAdminForm $model */
/** @var UsersController $type */

use app\controllers\UsersController;
use app\models\CreateAdminForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Добавить Пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="row">
        <div class="col-lg">
            <?php
            $form = ActiveForm::begin(['id' => 'form-create']); ?>
            <div class="mb-3">
                <?= $form->field($model, 'username')->textInput() ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'first_name')->textInput() ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'last_name')->textInput() ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'email') ?>
            </div>

            <div class="mb-4">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
            </div>

            <?php
            ActiveForm::end(); ?>
        </div>
    </div>
</div class="site-signup">
