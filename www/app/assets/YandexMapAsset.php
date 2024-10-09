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
class YandexMapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $sourcePath = '@app/theme';
    public $css = [];
    public $js = [];
    public $depends = [];
    public function registerAssetFiles($view)
    {
        $apiKey = env('API_YANDEX_MAP') ?? null;
        if($apiKey){
            $this->js[] = "https://api-maps.yandex.ru/2.1/?lang=en_RU&apikey=".$apiKey;
            $this->js[] = "js/yandex-map.js";
        }
        parent::registerAssetFiles($view);
    }
}
