<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class ListAsset extends AssetBundle
{
    /** @var string $basePath */
    public $basePath = '@webroot';

    /** @var string $sourcePath */
    public $sourcePath = '@app/theme';

    /** @var array $css */
    public $css = [
        'css/select2.min.css',
        'css/list.css',
    ];

    /** @var array $js */
    public $js = [
        'js/select2.min.js',
        'js/list.js',
    ];

    /** @var array */
    public $depends = [
        AppAsset::class,
    ];
}
