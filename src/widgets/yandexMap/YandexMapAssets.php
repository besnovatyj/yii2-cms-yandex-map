<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\widgets\yandexMap;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\AssetBundle;

class YandexMapAssets extends AssetBundle
{
    public $sourcePath = __DIR__ . '/media';

    public $css = ['css/yandex-map-widget.css'];
    public $js = ['js/yandex-map-widget.js'];

    /**
     * @throws InvalidConfigException
     */
    public function registerAssetFiles($view): void
    {
        $url = 'https://api-maps.yandex.ru/v3/?apikey=' . Yii::$app->getModule('YandexMap')->params['yandexApiKey'] . '&lang=ru_RU';
        $view->registerJsFile($url, ['position' => $view::POS_HEAD]);
        parent::registerAssetFiles($view);
    }

}
