<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\behaviors;

use Exception;
use Besnovatyj\YandexMap\entities\Map;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class LocationBehavior extends Behavior
{
    public string $attribute = 'location';
    public string $jsonAttribute = 'location_json';

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
        /** @var Map $model */
        $model = $event->sender;
        $meta = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->setLocation(
            ArrayHelper::getValue($meta, 'latitude'),
            ArrayHelper::getValue($meta, 'longitude'),
            ArrayHelper::getValue($meta, 'zoom')
        );
    }

    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode([
            'latitude' => $model->{$this->attribute}->getLatitude(),
            'longitude' => $model->{$this->attribute}->getLongitude(),
            'zoom' => $model->{$this->attribute}->getZoom(),
        ]));
    }
}
