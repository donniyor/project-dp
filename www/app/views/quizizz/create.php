<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Quizizz $model */

$this->title = 'Добавить опрос';
$this->params['breadcrumbs'][] = ['label' => 'Опросы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quizizz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
