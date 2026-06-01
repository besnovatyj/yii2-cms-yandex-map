<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

return [
    'label' => 'Yandex Map',
    'iconClass' => 'bi bi-pin-map',
    'url' => ['/YandexMap/backend/default/index'],
    'active' => static function () {
        return str_contains(\Yii::$app->request->url, 'YandexMap/backend/default/index');
    },
    '_meta' => [
        'placements' => [
            [
                'location' => 'left-sidebar',
                'group' => null,
                'priority' => 100,
            ],
        ],
    ],
];
