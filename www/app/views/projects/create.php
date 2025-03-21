<?php

declare(strict_types=1);

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Создать проект';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="projects-create">
                <h1><?= Html::encode($this->title) ?></h1>

                <?= $this->render('_form') ?>
            </div>
        </div>
    </div>
</div>
