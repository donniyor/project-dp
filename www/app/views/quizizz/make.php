<?php

use app\helpers\AnswerForm;
use app\helpers\QuestionForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $quiz */

$this->title = 'Добавить вопросы';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quizizz-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div id="w0" class="alert alert-danger position-fixed bottom-0 end-0 m-5 alert-dismissible error-massage" role="alert" style="display: none">
        <span id="error-massage"></span>
    </div>

    <?php foreach ($quiz->questions as $question) { ?>
        <div class="question-form">
            <?= QuestionForm::renderQuestionTextarea($question, $question->id)?>

            <div class="push-question">
                <div class="make-answer">
                    <?php foreach ($question->answerOptions as $answer) { ?>
                        <?= AnswerForm::renderAnswer($answer, $answer->id)?>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <?= Html::a('Добавить ответ', Url::to(['/answer-option/answer']), ['class' => 'btn btn-success btn-sm ajax-add-answer', 'data-id' => $question->id]) ?>
                </div>
            </div>
        </div>

    <?php } ?>


    <div class="make-question">
    </div>

    <?= Html::a('Добавить вопрос', Url::to(['/question/question', 'id' => $quiz->id]), ['class' => 'btn btn-success ajax-add-question']) ?>

</div>