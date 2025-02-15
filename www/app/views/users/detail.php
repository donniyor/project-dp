<?php

declare(strict_types=1);

/** @var yii\web\View $this */

/** @var app\models\Users $model */

use app\components\DatesInterface;
use app\helpers\Avatars;
use yii\bootstrap5\Html;

$this->title = 'Пользователь';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>

    <div class="row align-items-center my-3">
        <div class="col-auto">
            <?= Avatars::getAvatarSquare($model) ?>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= $model->getLastName() ?? '' ?>
                        <?= $model->getFirstName() ?? '' ?>
                    </h5>
                    <p class="card-text">
                        <?= $model->getEmail() ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-start bg-light mt-3">
        <small class="text-muted">
            Последнее обновление: <?= date(DatesInterface::DEFAULT_DATE, $model->getCreatedAt()) ?>
        </small>
    </div>
</div>

