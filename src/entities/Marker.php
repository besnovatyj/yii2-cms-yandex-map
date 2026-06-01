<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\entities;

use yii\base\InvalidValueException;

final readonly class Marker
{
    public function __construct(
        private float  $latitude, // 00.000000 - от −90° до 90°
        private float  $longitude, // 00.000000 - от-180° до 180°
        private string $color = '#808080',
        private string $title = '',
        private string $subTitle = '',
    )
    {
        if ($this->latitude < -90.000000 || $this->latitude > 90.000000) {
            throw new InvalidValueException('Latitude must be between -90.000000 and 90.000000.' . $this->latitude . 'given.');
        }
        if ($this->longitude < -180.000000 || $this->longitude > 180.000000) {
            throw new InvalidValueException('Longitude must be between -180.000000 and 180.000000.' . $this->longitude . 'given.');
        }
        if (!$this->colorValidate($this->color)) {
            throw new InvalidValueException('The color must be specified in HEX format.');
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

    public function getColor(): string
    {
        return $this->color;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    public function colorValidate($color): bool
    {
        return (bool)preg_match('/^(#[a-f0-9]{3}([a-f0-9]{3})?)$/i', $color);
    }

    public function getAsArray(): array
    {
        return [
            'coordinates' => [$this->longitude, $this->latitude],
            'color' => $this->color,
            'title' => $this->title,
            'subtitle' => $this->subTitle,
        ];
    }

}
