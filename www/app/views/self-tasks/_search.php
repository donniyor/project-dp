<?php

declare(strict_types=1);

use app\components\Statuses\Statuses;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="tasks-search">
    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <?= $form->field($data, 'title') ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <?= $form->field($data, 'status')->dropDownList(Statuses::getStatusList(), ['prompt' => '']) ?>
            </div>
        </div>
    </div>

    <div class="form-group mb-5">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Сбросить',
            Url::to(sprintf('/%s', Yii::$app->controller->getUniqueId())),
            ['class' => 'btn btn-secondary ms-3']
        ) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
