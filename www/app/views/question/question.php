<?php

use app\helpers\QuestionForm;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Questions $question */
/** @var app\models\AnswerOptions $answer */
/** @var yii\widgets\ActiveForm $form */
/** @var $id */
?>

<div class="question-form">


    <div class="mb-3">
        <?= QuestionForm::renderQuestionTextarea($question, $id)?>
    </div>

    <div class="push-question">
        <div class="make-answer">
        </div>

        <div class="mb-3">
            <?= Html::a('Добавить ответ', Url::to(['/answer-option/answer', 'id' => $id]), ['class' => 'btn btn-success btn-sm ajax-add-answer']) ?>
        </div>
    </div>


</div>
