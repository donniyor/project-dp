<?php
namespace app\helpers;  

use yii\helpers\Html;

class Image {
    public static function make(?string $img): string
    {
        return Html::img('/image?name='.$img, ['width' => 100, 'class' => 'm-1']);
    }
}