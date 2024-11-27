<?php

declare(strict_types=1);

namespace app\assets;

use yii\web\AssetBundle;

class KanbanAsset extends AssetBundle
{
    /** @var string $basePath */
    public $basePath = '@webroot';

    /** @var string $sourcePath */
    public $sourcePath = '@app/theme';

    /** @var array $css */
    public $css = [
        'css/jkanban.min.css',
        'css/kanban.css',
    ];

    /** @var array $js */
    public $js = [
        'js/jkanban.min.js',
        'js/kanban.js',
    ];

    /** @var array */
    public $depends = [
        AppAsset::class,
    ];
}
