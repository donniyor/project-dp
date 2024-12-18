<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\components\Statuses\Statuses;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $model */
/** @var yii\widgets\ActiveForm $form */

ListAsset::register($this);

$users = $model->getUsers(3);

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
                <?= $form->field($model, 'title') ?>
            </div>

            <div class="mb-3">
                <?= $form->field($model, 'author_id')
                    ->dropDownList(
                        [],
                        [
                            'multiple' => 'multiple',
                            'id' => 'author-id',
                            'class' => 'js-states form-control',
                            'tabindex' => '-1',
                            'style' => 'display: none; width: 100%',
                        ],
                    ) ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <?= $form->field($model, 'status')->dropDownList(Statuses::getStatusList(), ['prompt' => '']) ?>
            </div>

            <?= $form->field($model, 'assigned_to')
                ->dropDownList(
                    ArrayHelper::map($users, 'id', 'user'),
                    [
                        'multiple' => 'multiple',
                        'id' => 'assigned-to',
                        'class' => 'js-states form-control',
                        'tabindex' => '-1',
                        'style' => 'display: none; width: 100%',
                        'options' => ArrayHelper::map(
                            $users,
                            'id',
                            function ($user) {
                                return [
                                    'data-avatar-html' => $user['avatar'],
                                    'data-email' => $user['email'],
                                ];
                            }
                        )
                    ]
                ) ?>
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
