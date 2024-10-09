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
class ChartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $sourcePath = '@app/theme';
    public $css = [];
    public $js = [];
    public $depends = [];
    public function registerAssetFiles($view)
    {
        $this->js[] = "https://cdn.jsdelivr.net/npm/chart.js";
        $this->js[] = "https://cdn.jsdelivr.net/momentjs/latest/moment.min.js";
        $this->js[] = "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js";
        $this->css[] = "https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css";

        $this->js[] = "js/chart-create.js";
        parent::registerAssetFiles($view);
    }
}
