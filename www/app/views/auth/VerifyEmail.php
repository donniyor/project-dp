<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \app\models\ResetPasswordForm $model */

use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Подтверждение почты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
    <div class="app-auth-background">

    </div>
    <div class="app-auth-container">
        <?= Alert::widget() ?>
        <h2><?= Html::encode($this->title) ?></h2>
        <p>Перейдите по <?=Html::a('ссылке', Url::to(['auth/login']))?> для авторизации.</p>
    </div>
</div>