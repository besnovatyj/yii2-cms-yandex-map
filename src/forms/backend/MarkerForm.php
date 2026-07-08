<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\forms\backend;

use Besnovatyj\YandexMap\entities\Marker;
use yii\base\Model;

class MarkerForm extends Model
{
    public float $latitude = 0.000000;
    public float $longitude = 0.000000;
    public string $color = '#808080';
    public string $title = '';
    public string $subTitle = '';

    public function __construct(?Marker $marker = null, $config = [])
    {
        if ($marker) {
            $this->latitude = $marker->getLatitude();
            $this->longitude = $marker->getLongitude();
            $this->color = $marker->getColor();
            $this->title = $marker->getTitle();
            $this->subTitle = $marker->getSubTitle();
        }
        parent::__construct($config);
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            // Все действия здесь
            return true;
        }
        return false;
    }

    public function rules(): array
    {
        return [
            [['latitude', 'longitude'], 'required'],
            [['title', 'subTitle'], 'string', 'max' => 255],
            [['latitude'], 'double', 'min' => -90.000000, 'max' => 90.000000],
            [['longitude'], 'double', 'min' => -180.000000, 'max' => 180.000000],
            ['color', function ($attribute) {
                if (!preg_match('/^(#[a-f0-9]{3}([a-f0-9]{3})?)$/i', $this->$attribute)) {
                    $this->addError($attribute, 'The color must be specified in HEX format.');
                }
            }],
        ];
    }

}
