<?php

declare(strict_types=1);

use app\assets\ListAsset;
use app\components\DatesInterface;
use app\helpers\Data;
use app\models\Projects;
use kartik\datetime\DateTimePicker;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $task */
/** @var Projects $projecct */

$this->title = 'Создать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

ListAsset::register($this);

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="tasks-create">
                <div class="tasks-form">
                    <?php
                    $form = ActiveForm::begin(); ?>

                    <div class="mb-3">
                        <?= Html::label('Название') ?>
                        <?= Html::textInput(
                            'title',
                            $task['title'] ?? '',
                            ['maxlength' => true, 'class' => 'form-control']
                        ) ?>
                    </div>

                    <div>
                        <?= Html::label('Срок', 'deadline', ['class' => 'form-label']) ?>
                        <?= DateTimePicker::widget([
                            'name' => 'deadline',
                            'value' => date(DatesInterface::DEFAULT_DATE_TIME),
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
                        <?= Html::label('Описание') ?>
                        <?= Data::getTextArea('description', $task['description'] ?? '') ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Исполнитель') ?>
                        <?= Html::dropDownList(
                            'assigned_to',
                            null,
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
                            $task['project_id'] ?? null,
                            isset($project) ? ArrayHelper::map([$project], 'id', 'title') : [],
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
                            'status',
                            null,
                            [],
                            [
                                'id' => 'status-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите статус',
                            ],
                        )
                        ?>
                    </div>

                    <div class="mb-3">
                        <?= Html::label('Приоритет', 'priority-id', ['class' => 'form-label']) ?>
                        <?= Html::dropDownList(
                            'priority',
                            $task['priority'] ?? '',
                            isset ($priority) ? ArrayHelper::map($priority, 'id', 'title') : [],
                            [
                                'id' => 'priority-id',
                                'class' => 'js-states form-control',
                                'style' => 'width: 100%',
                                'prompt' => 'Выберите Приоритет',
                            ],
                        ); ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php
                    ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
