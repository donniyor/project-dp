<?php

declare(strict_types=1);

use app\components\Avatars;
use app\components\DatesInterface;
use app\components\Statuses\Statuses;
use yii\helpers\Html;
use yii\web\YiiAsset;

/** @var yii\web\View $this */
/** @var app\models\Projects $model */

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="projects-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row">
        <div class="col-md-9">
            <div class="projects-form card p-3 bg-light">
                <div class="mb-3">
                    <?= Html::label('Название', 'title', ['class' => 'control-label']) ?>
                    <br>
                    <?= Html::encode($model->getTitle()) ?>
                </div>
                <hr>

                <div class="mb-3">
                    <?= Html::label('Описание', 'description', ['class' => 'control-label']) ?>
                    <br>
                    <?= $model->getDescription() ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light p-3">
                <div class="mb-3 text-center">
                    <?= Statuses::getStatusButton($model->getStatus())?>
                </div>
                <?= Html::label('Автор', 'author_id', ['class' => 'control-label']) ?>
                <div class="mb-3 rounded text-center">
                    <?= Avatars::getAvatarRound($model->getAuthorModel()) ?>
                    <h1 class="h4 font-weight-bold mt-3">
                        <?= $model->getAuthorModel()->getLastName() ?? '' ?>
                        <?= $model->getAuthorModel()->getFirstName() ?? $model->getAuthorModel()->getEmail() ?>
                    </h1>
                </div>

                <div class="mt-3 text-center">
                    <?= Html::label('Дата начала проекта', 'created_at', ['class' => 'control-label']) ?>
                    <?= $model->getCreatedAt() !== null
                        ? date(DatesInterface::DEFAULT_DATE, strtotime($model->getCreatedAt()))
                        : '' ?>
                </div>
            </div>
        </div>
    </div>

</div>
