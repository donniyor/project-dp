<?php

declare(strict_types=1);

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */

/* @var array $data */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Регистрация';

?>

<div class="d-flex flex-wrap justify-content-center align-content-center min-vh-100">
    <div class="app-auth-container">
        <?= Alert::widget() ?>

        <h5 class="sign-in mb-3">Регистрация</h5>

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

        <?= Html::label('Почта') ?>
        <?= Html::textInput(
            'email',
            $data['email'] ?? '',
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
            Уже есть аккаунт ? <?= Html::a('Войти', Url::to(['auth/in'])) ?>.
        </div>

        <div class="form-group">
            <div>
                <?= Html::submitButton('Создать', ['class' => 'btn btn-success my-3', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php
        ActiveForm::end(); ?>
    </div>
</div>