<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\views\backend\default\assets;

use yii\web\AssetBundle;
use yii\web\View;

class Assets extends AssetBundle
{
    public $sourcePath = __DIR__ . '/media/dist';

    public $js = [
        'index.js',
    ];

    public $css = [
        'styles.css',
    ];

    public $jsOptions = [
        'position' => View::POS_END,
        'type' => 'module'
    ];
}
