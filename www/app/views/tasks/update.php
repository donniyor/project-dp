<?php

declare(strict_types=1);

use yii\helpers\Html;
use app\assets\ListAsset;
use app\helpers\Avatars;
use app\helpers\Data;
use app\models\Tasks;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var Tasks $model */
/** @var array $statuses */
/** @var ActiveForm $form */

$this->title = 'Редактировать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';

ListAsset::register($this);

?>
<div class="container">
    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-md-9">
            <div class="task-form">
                <div class="mb-3">
                    <?= Html::label('Название') ?>
                    <?= Html::textInput(
                        'title',
                        $model->getTitle(),
                        ['maxlength' => true, 'class' => 'form-control']
                    ) ?>
                </div>

                <div class="mb-3">
                    <?= Html::label('Описание') ?>
                    <?= Data::getTextArea('description', $model->getDescription()) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-header">О задаче</div>
                <div class="card-body">

                    <?= Html::label('Автор', 'author_id', ['class' => 'control-label']) ?>
                    <div class="mb-3 user-inline">
                        <?= Avatars::getAvatarRound($model->getAuthorModel(), 40) ?>
                        <?= $model->getAuthorModel()->getLastName() ?? '' ?>
                        <?= $model->getAuthorModel()->getFirstName() ?? $model->getAuthorModel()->getEmail() ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Исполнитель') ?>
                        <?= Html::dropDownList(
                            'assigned_to',
                            '',
                            [],
                            [
                                'id' => 'assigned-to',
                                'class' => 'js-states form-control',
                                'tabindex' => '-1',
                                'style' => 'display: none; width: 100%',
                                'prompt' => 'Выберите исполнителя',
                            ],
                        ) ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Проект') ?>
                        <?= Html::dropDownList(
                            'project_id',
                            $model->getProjectId(),
                            [],
                            [
                                'id' => 'project-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите проект',
                            ],
                        ) ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Статус') ?>
                        <?=
                        Html::dropDownList(
                            'status_id',
                            $model->getStatus(),
                            $statuses ?? [],
                            [
                                'id' => 'status-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите статус',
                            ],
                        )
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    ActiveForm::end();
    ?>
</div>
