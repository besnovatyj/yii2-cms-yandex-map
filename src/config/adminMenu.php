<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\Contracts\adminMenu\AdminMenuLocation;
use Besnovatyj\Contracts\adminMenu\AdminMenuPlacement;

return [[
    'label' => 'Yandex Map',
    'iconClass' => 'bi bi-pin-map',
    'url' => ['/YandexMap/backend/default/index'],
    'active' => static function () {
        return str_contains(\Yii::$app->request->url, 'YandexMap/backend/default/index');
    },
    '_meta' => [
        'placements' => [
            new AdminMenuPlacement(
                location: AdminMenuLocation::LeftSidebar,
                group: null,
                priority: 100,
            ),
        ],
    ],
]];
