<?php

declare(strict_types=1);

namespace app\components;

use app\models\Users;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Avatars
{
    public static function getAvatarSquare(Users $model): string
    {
        if ($model->getImageUrl()) {
            $url = $model->getImageUrl();
            return "<img src=\"$url\"
                alt='avatar'
                class='img-thumbnail'
                style='width: 200px; height: 200px; object-fit: cover;'>";
        }

        $letter = strtoupper(mb_substr($model->getUsername(), 0, 1));
        return "<div class='avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold'
            style='width: 200px; height: 200px; background-color: #6c757d; font-size: 36px;'>
            $letter
            </div>";
    }

    public static function getAvatarRound(?Users $model, int $size = 100, bool $hasUrl = true): string
    {
        $hoverClass = 'avatar-hover';
        $fontSize = $size / 3;

        if ($model === null) {
            $img = Html::tag(
                'div',
                Html::tag('i', 'person', ['class' => 'material-icons']),
                [
                    'class' => "avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold $hoverClass",
                    'style' => "width: {$size}px; height: {$size}px; background-color: #b8b8b8; font-size: {$fontSize}px; border-radius: 50%; border: 2px solid #0d6efd;"
                ]
            );

            return Html::a(
                sprintf('%s Назначить себе', $img),
                Url::to(['/task/get-task', Yii::$app->getUser()->getId()]),
                [
                    'class' => 'text-muted text-center text-decoration-none d-flex flex-column align-items-center justify-content-center',
                    'style' => 'font-size: 0.875rem; height: 100%;'
                ]
            );
        }

        $url = Url::to(['users/detail', 'id' => $model->getId()]);

        if ($model->getImageUrl()) {
            $img = Html::img($model->getImageUrl(), [
                'alt' => 'avatar',
                'class' => $hoverClass,
                'style' => "width: {$size}px; height: {$size}px; object-fit: cover; border-radius: 50%; border: 2px solid #0d6efd;"
            ]);

            return $hasUrl ? Html::a($img, $url, ['class' => 'd-flex justify-content-center']) : $img; // Добавление классов для центровки
        }

        $tag = Html::tag('div', strtoupper(mb_substr($model->getUsername(), 0, 1)), [
            'class' => "avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold $hoverClass",
            'style' => "width: {$size}px; height: {$size}px; background-color: #6c757d; font-size: {$fontSize}px; border-radius: 50%; border: 2px solid #0d6efd;"
        ]);

        return $hasUrl ? Html::a($tag, $url, ['style' => 'text-decoration: none;', 'class' => 'd-flex justify-content-center']) : $tag; // Добавление классов для центровки
    }

}
