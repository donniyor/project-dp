<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $model */

$this->title = 'Редактировать опрос: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="quizizz-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
