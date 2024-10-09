<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Поздравляем вы прошли тест';
$this->params['breadcrumbs'][] = $this->title;
$count = 1;
?>
<div>
    <h1><?= Html::encode($this->title) ?></h1>
</div>
