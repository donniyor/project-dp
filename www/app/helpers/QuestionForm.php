<?php

namespace app\helpers;

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Questions;

class QuestionForm
{
    public static function renderQuestionTextarea(Questions $question, int $id): string
    {
        return static::generateTextareaHtml($question, $id);
    }

    protected static function generateTextareaHtml(Questions $question, int $id): string
    {
        $textareaAttributes = [
            'maxlength' => true,
            'class' => 'form-control ajax-question-save',
            'data-url' => Url::to('/question/save-question'),
            'data-quiz_id' => $question->quiz_id ?? $id,
            'data-id' => $question->id
        ];

        $textarea = Html::textarea('QuestionForm', $question->question, $textareaAttributes);
        $label = Html::label('Вопрос', null, ['class' => 'form-label']);

        return "<div class=\"mb-3\">$label$textarea</div>";
    }
}
