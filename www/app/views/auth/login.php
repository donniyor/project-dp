<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Авторизация';
?>

<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <span class="sign-in">Авторизация</span>
        <div class="divider"></div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="my-1 mx-0" style="color:#999;">
            Если вы забыли пароль вы можете <?= Html::a('сбросить его', ['auth/request-password-reset']) ?>.
        </div>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary my-3', 'name' => 'login-button']) ?>
            </div>
        </div>

        <p>Еще нет аккаунта <?=Html::a('создать', Url::to(['sing-up']))?></p>


        <?php ActiveForm::end(); ?>
    </div>
</div>