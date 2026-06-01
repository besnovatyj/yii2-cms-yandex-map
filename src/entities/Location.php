<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\entities;

use yii\base\InvalidValueException;

final readonly class Location
{
    public function __construct(
        private float $latitude, // 00.000000 - от −90° до 90°
        private float $longitude, // 00.000000 - от-180° до 180°
        private int   $zoom = 1 //
    )
    {
        if ($this->latitude < -90.000000 || $this->latitude > 90.000000) {
            throw new InvalidValueException('Latitude must be between -90.000000 and 90.000000.' . $latitude . 'given.');
        }
        if ($this->longitude < -180.000000 || $this->longitude > 180.000000) {
            throw new InvalidValueException('Longitude must be between -180.000000 and 180.000000.' . $longitude . 'given.');
        }
        if ($this->zoom < 0) {
            throw new InvalidValueException('Zoom must be greater than 0.');
        }
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getZoom(): ?int
    {
        return $this->zoom;
    }

    public function getCenter(): array
    {
        return [$this->longitude, $this->latitude];
    }

}
