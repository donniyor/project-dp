<?php

declare(strict_types=1);

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var View $this */
/* @var ActiveForm $form */
/* @var array $data */

$this->title = 'Войти в аккаунт';

?>

<div class="d-flex flex-wrap justify-content-center align-content-center min-vh-100">
    <div class="app-auth-container min-vh-50">
        <?= Alert::widget() ?>

        <h5 class="sign-in mb-3">Войти в аккаунт</h5>

        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

        <?= Html::label('Логин') ?>
        <?= Html::textInput(
            'username',
            $data['username'] ?? '',
            [
                'class' => 'form-control mb-3',
                'autofocus' => true,
            ],
        ) ?>

        <?= Html::label('Пароль') ?>
        <?= Html::passwordInput(
            'password',
            $data['password'] ?? '',
            [
                'class' => 'form-control mb-3',
                'autofocus' => true,
            ],
        ) ?>

        <div class="my-1 mx-0" style="color:#999;">
            Если еще не зарегистрированы <?= Html::a('Регистрация', Url::to(['auth/registration'])) ?>.
        </div>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Вход', ['class' => 'btn btn-success my-3', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php
        ActiveForm::end(); ?>
    </div>
</div>