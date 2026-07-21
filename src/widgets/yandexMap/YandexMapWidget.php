<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\widgets\yandexMap;

use Besnovatyj\Contracts\shortcode\ShortcodeTextResolver;
use Besnovatyj\YandexMap\repositories\MapRepository;
use Besnovatyj\Helpers\json\Json;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

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

        $placeholder = $this->resolvePlaceholder((string)$map->placeholder);
        $style = $placeholder !== ''
            ? ' style="background-image: url(\'' . Html::encode($placeholder) . '\')"'
            : '';

        return '<div class="yandex-map h-300 ' . $map->cssClass . '" data-markers=\'' . $markers . '\' data-location=\'' . $location . '\'' . $style . '></div>';
    }

    /**
     * Разворачивает текстовые шорткоды (например, `%staticHost%`) в URL плейсхолдера.
     *
     * Модуль шорткодов необязателен для минимальной установки, поэтому компонент используется
     * только если он зарегистрирован и реализует контракт {@see ShortcodeTextResolver}. Иначе URL
     * возвращается как есть.
     *
     * @param string $placeholder URL плейсхолдера, возможно с шорткодами
     * @return string URL с развёрнутыми шорткодами
     */
    private function resolvePlaceholder(string $placeholder): string
    {
        if ($placeholder === '' || !Yii::$app->has('shortcode')) {
            return $placeholder;
        }

        $resolver = Yii::$app->get('shortcode');

        return $resolver instanceof ShortcodeTextResolver
            ? $resolver->resolveText($placeholder)
            : $placeholder;
    }

}
