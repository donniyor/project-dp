<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Регистрация';
?>

<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <span class="sign-in">Регистрация</span>
        <div class="divider"></div>

        <?php $form = ActiveForm::begin(['id' => 'form-create']); ?>
        <div class="mb-3">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'email') ?>
        </div>
        <div class="mb-3">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success my-3', 'name' => 'signup-button']) ?>
        </div>

        <p>Уже есть аккаунт <?=Html::a('вход', Url::to(['in']))?></p>

        <?php ActiveForm::end(); ?>
    </div>
</div>