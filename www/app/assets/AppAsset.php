<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@app/theme';
    public $css = [
        'css/site.css',
        'css/custom.css',
    ];
    public $js = [
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapIconAsset',
    ];
}
