<?php

declare(strict_types=1);

use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
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
/** @var array $project */
/** @var array $priority */
/** @var array $assignedTo */
/** @var ActiveForm $form */

$this->title = 'Редактировать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Беклог', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Канбан', 'url' => ['/kanban']];
$this->params['breadcrumbs'][] = $this->title;

ListAsset::register($this);

?>

<div class="container">
    <?php
    $form = ActiveForm::begin();
    ?>

    <div class="row">
        <div class="col-md-8">
            <div class="task-form">
                <div class="mb-3">
                    <?= Html::label('Название') ?>
                    <?= Html::textInput(
                        'title',
                        $model->getTitle(),
                        ['maxlength' => true, 'class' => 'form-control'],
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

        <div class="col-md-4">
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
                            $model->getAssignedToUserId(),
                            isset($assignedTo) ? ArrayHelper::map($assignedTo, 'id', 'user') : [],
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
                            isset($project) ? ArrayHelper::map([$project], 'id', 'title') : [],
                            [
                                'id' => 'project-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите проект',
                            ],
                        ); ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Срок', 'deadline', ['class' => 'form-label']) ?>
                        <?= DateTimePicker::widget([
                            'name' => 'deadline',
                            'value' => $model->getDeadLine(),
                            'options' => [
                                'placeholder' => 'Выберите дату и время...',
                                'class' => 'form-control'
                            ],
                            'type' => DateTimePicker::TYPE_INPUT,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-M-yyyy HH:ii P',
                                'todayHighlight' => true,
                            ],
                            'pickerButton' => [
                                'label' => '<i class="material-icons">event</i>',
                            ],
                            'removeButton' => [
                                'label' => '<i class="material-icons">clear</i>',
                            ],
                        ]) ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Статус') ?>
                        <?= Html::dropDownList(
                            'status',
                            $model->getStatus(),
                            isset($statuses) ? ArrayHelper::map($statuses, 'id', 'title') : [],
                            [
                                'id' => 'status-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите статус',
                            ],
                        ); ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Приоритет', 'priority-id', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList(
                            'priority',
                            $model->getPriority(),
                            isset ($priority) ? ArrayHelper::map($priority, 'id', 'title') : [],
                            [
                                'id' => 'priority-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите Приоритет',
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
