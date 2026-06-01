<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\forms\backend;

use Besnovatyj\Forms\BaseForm;
use Besnovatyj\YandexMap\entities\Location;
use yii\base\Model;

class LocationForm extends BaseForm
{
    public float $latitude = 0.000000;
    public float $longitude = 0.000000;
    public int $zoom = 1;

    public function __construct(Location $location = null, $config = [])
    {
        if ($location) {
            $this->latitude = $location->getLatitude();
            $this->longitude = $location->getLongitude();
            $this->zoom = $location->getZoom();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['latitude', 'longitude', 'zoom'], 'required'],
            ['zoom', 'integer'],
            [['latitude'], 'double', 'min' => -90.000000, 'max' => 90.000000],
            [['longitude'], 'double', 'min' => -180.000000, 'max' => 180.000000],
        ];
    }

}
