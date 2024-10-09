<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\TestSolution $model */

/** @var app\models\Quizizz $quiz */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Пройти тест';
$this->params['breadcrumbs'][] = $this->title;
$count = 1;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="row">
        <div class="col-lg">


            <?php $form = ActiveForm::begin(); ?>

            <?php foreach ($quiz->questions as $index => $question) { ?>
                <?php if (count($question->answerOptions) > 0) { ?>
                    <div class="solution-form">
                        <div class="alert alert-custom alert-indicator-top indicator-info">
                            <div class="alert-content">
                                <span class="alert-title">[<?= $count++ ?>] Вопрос</span>
                                <span class="alert-text"><?= $question->question ?></span>
                            </div>
                        </div>
                        <div class="ps-5">
                            <table class="table table-bordered">
                                <?php foreach ($question->answerOptions as $key => $answer) { ?>
                                    <tr>
                                        <td>
                                            <?= $answer->id . '-' . $answer->question_id ?>
                                            <?= Html::radio("answer[$index]", false, ['label' => $answer->answer, 'value' => $answer->id . '-' . $answer->question_id]) ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
