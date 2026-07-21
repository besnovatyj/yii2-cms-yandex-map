<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

// Все опции должны быть изначально определены при в конфигурации модуля при подключении в приложение.
return [
    'yandex_api_key' => [
        'path' => 'modules.YandexMap.params.yandexApiKey',
        'label' => 'Yandex JavaScript API Key',
        'description' => "Yii::\$app->getModule('yandexMap')->params['yandexApiKey'] (<a target=\"_blank\" href=\"https://developer.tech.yandex.ru/keys?modern=true\">Список ключей</a>)",
        'group' => '',
        'category' => 'YandexMap',
        'rules' => [
            ['string']
        ],
        'inputOptions' => [
            'type' => 'input',
        ],
    ],
];
