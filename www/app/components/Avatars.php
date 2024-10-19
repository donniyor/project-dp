<?php

declare(strict_types=1);

namespace app\components;

use app\models\Users;

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

    public static function getAvatarRound(Users $model): string
    {
        if ($model->getImageUrl()) {
            $img = $model->getImageUrl();
            return "<img src=\"$img\"
                alt='avatar'
                class='img-thumbnail'
                style='width: 100px; height: 100px; object-fit: cover; border-radius: 50%;'>";
        }

        $letter = strtoupper(mb_substr($model->getUsername(), 0, 1));
        return "<div class='avatar-placeholder d-flex align-items-center justify-content-center text-white fw-bold'
            style='width: 100px; height: 100px; background-color: #6c757d; font-size: 24px; border-radius: 50%;'>
            $letter
            </div>";
    }
}