<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\helpers\Avatars;
use app\helpers\Data;
use app\models\Projects;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var array $data */
/** @var array $statuses */
/** @var Projects $model */

$this->title = 'Редактировать проект';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';

ListAsset::register($this);

?>

<div class="projects-update">
    <div class="container">
        <?php
        $form = ActiveForm::begin();
        ?>

        <div class="row">
            <div class="col-md-9">
                <div class="projects-form">
                    <div class="mt-3">
                        <?= Html::label('Название проекта') ?>
                        <?= Html::textInput(
                            'title',
                            $data['title'] ?? '',
                            [
                                'maxlength' => true,
                                'class' => 'form-control',
                            ],
                        ) ?>
                    </div>

                    <div class="mt-3">
                        <?= Html::label('Описание') ?>
                        <?= Data::getTextArea(
                            'description',
                            $data['description'] ?? '',
                        ) ?>
                    </div>

                    <div class="form-group mb-3">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card bg-light">
                    <div class="card-header">О проекте</div>
                    <div class="card-body">
                        <?= Html::label('Автор', 'author_id', ['class' => 'control-label']) ?>
                        <div class="mb-3 user-inline">
                            <?= Avatars::getAvatarRound($model->getAuthorModel(), 40) ?>
                            <?= $model->getAuthorModel()->getLastName() ?? '' ?>
                            <?= $model->getAuthorModel()->getFirstName() ?? $model->getAuthorModel()->getEmail() ?>
                        </div>

                        <div class="mb-3">
                            <?= Html::label('Статус') ?>
                            <?= Html::dropDownList(
                                'status',
                                $data['status'] ?? '',
                                isset($statuses)
                                    ? ArrayHelper::map($statuses, 'id', 'title')
                                    : [],
                                [
                                    'id' => 'status-id',
                                    'class' => 'js-states form-control',
                                    'style' => 'width: 100%',
                                    'prompt' => 'Выберите статус',
                                ],
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
