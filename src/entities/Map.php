<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\entities;

use Besnovatyj\YandexMap\behaviors\LocationBehavior;
use Besnovatyj\YandexMap\behaviors\MarkerBehavior;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $name
 * @property string $cssClass
 * @property string $placeholder URL изображения-плейсхолдера, показываемого до загрузки карты
 *
 * @property Marker[] $markers
 * @property Location $location
 *
 * @see https://yandex.ru/dev/jsapi30/doc/ru/
 */
class Map extends ActiveRecord
{
    private Location $location;
    private array $markers = [];

    public static function create(string $name, string $cssClass, string $placeholder): self
    {
        $map = new static();
        $map->name = $name;
        $map->cssClass = $cssClass;
        $map->placeholder = $placeholder;
        return $map;
    }

    public function edit(string $name, string $cssClass, string $placeholder): void
    {
        $this->name = $name;
        $this->cssClass = $cssClass;
        $this->placeholder = $placeholder;
    }

    public function setLocation($latitude, $longitude, $zoom): void
    {
        $this->location = new Location($latitude, $longitude, $zoom);
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function getLocationFormatted(): array
    {
        return [
            'center' => $this->location->getCenter(),
            'zoom' => $this->location->getZoom(),
        ];
    }

    public function clearMarkers(): void
    {
        $this->markers = [];
    }

    public function addMarker(Marker $marker): void
    {
        $this->markers[] = $marker;
    }

    public function getMarkers(): array
    {
        return $this->markers;
    }

    public function getMarkersFormatted(): array
    {
        return array_map(static function (Marker $marker) {
            return $marker->getAsArray();
        }, $this->markers);
    }


    public function behaviors(): array
    {
        return [
            MarkerBehavior::class,
            LocationBehavior::class,
            ...parent::behaviors(),
        ];
    }


    public static function tableName(): string
    {
        return '{{%yandex_map_maps}}';
    }

}
