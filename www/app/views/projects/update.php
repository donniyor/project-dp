<?php

declare(strict_types=1);

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Projects $model */

$this->title = 'Редактировать проект';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="projects-update">
    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>
</div>
