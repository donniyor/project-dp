<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
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
        'js/custom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'yii\bootstrap5\BootstrapIconAsset'
    ];
}
