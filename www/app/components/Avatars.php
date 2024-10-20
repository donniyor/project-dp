<?php

declare(strict_types=1);

namespace app\components;

use app\models\Users;
use yii\helpers\Html;

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

    public static function getAvatarRound(Users $model, int $size = 100): string
    {
        $hoverClass = 'avatar-hover';

        if ($model->getImageUrl()) {
            $img = Html::img($model->getImageUrl(), [
                'alt' => 'avatar',
                'class' => $hoverClass,
                'style' => "width: {$size}px; height: {$size}px; object-fit: cover; border-radius: 50%; border: 2px solid #0d6efd;"
            ]);

            return Html::a($img, ['users/detail', 'id' => $model->getId()]);
        }

        $letter = strtoupper(mb_substr($model->getUsername(), 0, 1));
        return Html::tag('div', $letter, [
            'class' => "avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold $hoverClass",
            'style' => "width: {$size}px; height: {$size}px; background-color: #6c757d; font-size: 24px; border-radius: 50%; border: 2px solid #0d6efd;"
        ]);
    }

}