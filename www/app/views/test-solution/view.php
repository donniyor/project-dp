<?php

/** @var yii\web\View $this */

/** @var app\models\Quizizz $quiz */
/** @var app\models\TestSolution $testSolution */

use yii\bootstrap5\Html;

$this->title = 'Статистика теста';
$this->params['breadcrumbs'][] = ['label' => 'Результаты опросов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$count = 1;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <div class="row">
        <div class="col-lg">

            <div class="alert alert-custom alert-indicator-top indicator-success">
                <div class="alert-content">
                    <h4>Популярность опроса</h4>
                    <p>Количество людей прошедших опрос: <span class="badge rounded-pill badge-success p-2"><?= count($testSolution) ?></span></p>
                </div>
            </div>

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
                                            <span class="badge rounded-pill badge-success p-2"><?= count($answer->problemSolvings) ?></span>
                                            <?=$answer->answer?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
