<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\widgets\yandexMap;

use Besnovatyj\YandexMap\repositories\MapRepository;
use Besnovatyj\Helpers\json\Json;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Виджет Яндекс карт
 */
class YandexMapWidget extends Widget
{
    public int|null $id = null;
    private MapRepository $maps;

    /**
     * @throws InvalidConfigException
     */
    public function __construct(MapRepository $maps, $config = [])
    {
        parent::__construct($config);
        $this->maps = $maps;

        if (empty(Yii::$app->getModule('YandexMap')->params['yandexApiKey'])) {
            throw new InvalidConfigException('Не задан Яндекс API ключ');
        }

    }

    public function run(): string
    {
        YandexMapAssets::register($this->getView());

        $map = $this->maps->get($this->id);

        $markers = Json::encode($map->getMarkersFormatted());
        $location = Json::encode($map->getLocationFormatted());

        return '<div class="yandex-map h-300 ' . $map->cssClass . '" data-markers=\'' . $markers . '\' data-location=\'' . $location . '\'></div>';
    }

    //START============================================
    //for shortcodes module

    /**
     * Content inner shortcode
     * ```
     * [code]...content here...[\code]
     * ```
     * @var string
     */
    public string $content;

    /**
     * @param string $name
     * @param mixed $string
     */
    public function __set($name, $string)
    {
        if (property_exists($this, $name)) {
            $this->$name = $string;
        }
    }

    //END============================================

}

// TODO Сделать возможным задавать расположение картинки
//.yandex-map {
//    width: 100%;
//    padding: 0;
//    background-image: url(/static_assets_bd/images/custom/ymap.jpg);
//    background-position: center center;
//}
