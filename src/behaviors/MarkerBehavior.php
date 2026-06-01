<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\behaviors;

use Exception;
use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\entities\Marker;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class MarkerBehavior extends Behavior
{
    public $attribute = 'markers';
    public $jsonAttribute = 'markers_json';

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    /**
     * @throws Exception
     */
    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $markers = Json::decode($model->getAttribute($this->jsonAttribute));
        array_map(static function ($marker) use ($model) {
            $marker = new Marker(
                ArrayHelper::getValue($marker, 'latitude'),
                ArrayHelper::getValue($marker, 'longitude'),
                ArrayHelper::getValue($marker, 'color'),
                ArrayHelper::getValue($marker, 'title'),
                ArrayHelper::getValue($marker, 'subTitle'),
            );
            $model->addMarker($marker);
        }, $markers);
    }

    public function onBeforeSave(Event $event): void
    {
        /** @var Map $map */
        $map = $event->sender;
        $markers = [];
        foreach ($map->{$this->attribute} as $marker) {
            $markers[] = [
                'latitude' => $marker->getLatitude(),
                'longitude' => $marker->getLongitude(),
                'color' => $marker->getColor(),
                'title' => $marker->getTitle(),
                'subTitle' => $marker->getSubTitle(),
            ];
        }
        $map->setAttribute($this->jsonAttribute, Json::encode($markers));
    }
}












