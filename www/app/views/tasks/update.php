<?php

declare(strict_types=1);

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = 'Редактировать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getId(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
