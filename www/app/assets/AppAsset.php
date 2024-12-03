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
        'plugins/perfectscroll/perfect-scrollbar.css',
        'plugins/pace/pace.css',
        'plugins/flatpickr/flatpickr.min.css',
        'css/main.css',
        'css/custom.css',
    ];
    public $js = [
        'plugins/perfectscroll/perfect-scrollbar.min.js',
        'plugins/pace/pace.min.js',
        'plugins/flatpickr/flatpickr.js',
        'js/main.min.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapIconAsset',
    ];
}
