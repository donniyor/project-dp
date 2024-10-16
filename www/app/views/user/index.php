<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var app\models\Users $model */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user;

?>

<div class="user-index container mt-5">
    <div class="card shadow-b border-0 p-4">
        <div class="row align-items-start">
            <div class="col-auto">
                <?php if ($model->getImageUrl()): ?>
                    <img src="<?= $model->getImageUrl() ?>"
                         alt="avatar"
                         class="img-thumbnail"
                         style="width: 200px; height: 200px; object-fit: cover;">
                <?php else: ?>
                    <div class="avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold"
                         style="width: 200px; height: 200px; background-color: #6c757d; font-size: 36px;">
                        <?= strtoupper(mb_substr($model->getUsername(), 0, 1)) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col">
                <h2 class="text-dark mb-1"><?= $model->getUsername(); ?></h2>
                <p class="text-muted mb-2"><?= $model->getEmail(); ?></p>
            </div>

            <div class="d-flex justify-content-end mt-2">
                <a href="<?= Yii::$app->urlManager->createUrl(['update']) ?>"
                   class="btn btn-outline-success btn-sm">
                    Редактировать Аккаунт
                </a>
            </div>
        </div>

        <div class="card-footer text-start bg-light mt-3">
            <small class="text-muted">Последнее обновление: <?= date('d.m.Y') ?></small>
        </div>
    </div>
</div>
