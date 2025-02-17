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
        'css/jquery-ui.min.css',
        'css/boards.css',
    ];

    /** @var array $js */
    public $js = [
        'js/jkanban.min.js',
        'js/kanban.js',
        'js/jquery-ui.min.js',
        'js/boards.js',
    ];

    /** @var array */
    public $depends = [
        AppAsset::class,
    ];
}
