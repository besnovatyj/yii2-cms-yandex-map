<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\forms\backend;

use Besnovatyj\Forms\CompositeForm;
use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\entities\Marker;

/**
 * @property MarkerForm[] $markers
 * @property LocationForm $location
 */
class MapForm extends CompositeForm
{
    public $name;
    public $cssClass;

    public function __construct(?Map $map = null, $config = [])
    {
        if ($map) {
            $this->name = $map->name;
            $this->cssClass = $map->cssClass;
            $this->markers = array_map(static function (Marker $marker) {
                return new MarkerForm($marker);
            }, $map->markers);
            $this->location = new LocationForm($map->location);
        } else {
//            $this->name = '';
//            $this->cssClass = '';
            $this->markers = [new MarkerForm()];
            $this->location = new LocationForm();
        }
        parent::__construct($config);
    }

    public function loadMarkerForms(array $markers): void
    {   // Композитная форма, как и обычная модель Yii2, не знает сколько 'MarkerForm' поступило из контроллёра
        // и загружает данные только в формы заданные в текущем конструкторе
        $markerForms = [];
        foreach ($markers as $marker) {
            $markerForm = new MarkerForm();
            $markerForm->latitude = (float)$marker['latitude'];
            $markerForm->longitude = (float)$marker['longitude'];
            $markerForm->color = (string)$marker['color'];
            $markerForm->title = (string)$marker['title'];
            $markerForm->subTitle = (string)$marker['subTitle'];
            $markerForms[] = $markerForm;
        }
        $this->markers = $markerForms;
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            // Логика здесь
            return true;
        }
        return false;
    }

    public function rules(): array
    {
        return [
            [['name',], 'required'],
            [['name', 'cssClass',], 'string', 'max' => 255],
        ];
    }

    protected function internalForms(): array
    {
        return ['markers', 'location',];
    }

}
