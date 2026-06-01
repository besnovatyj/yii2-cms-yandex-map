<?php

/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

return [
    'tables' => [
        // https://www.yiiframework.com/doc/api/2.0/yii-db-querybuilder#getColumnType()-detail
        // @see \yii\db\QueryBuilder::getColumnType()
        '{{%yandex_map_maps}}' => [
            'columns' => [
                'id' => 'pk',
                'name' => 'string NOT NULL DEFAULT "Введите название карты"',
                'cssClass' => 'string NULL DEFAULT NULL',
                'location_json' => 'text NOT NULL',
                'markers_json' => 'text NOT NULL',
            ],
            'comments' => [
                'id' => 'pk',
                'name' => 'Название карты',
                'cssClass' => 'Стили для главного тега карты',
                'location_json' => 'JSON of Location',
                'markers_json' => 'JSON of Markers',
            ],
            'comment' => 'Яндекс карты',
        ],

    ],

    'initialData' => [
        // DEMO
        '{{%yandex_map_maps}}' => [
            [
                'id' => '1',
                'name' => 'МАУК "БДТ"',
                'cssClass' => '',
                'location_json' => '{"latitude":59.403648,"longitude":56.811722,"zoom":15}',
                'markers_json' => '[{"latitude":59.403648,"longitude":56.811722,"color":"#A52A2A","title":"МАУК \\"БДТ\\"","subTitle":""}]',
            ],
            [
                'id' => '2',
                'name' => 'МАУК "БДТ" 2',
                'cssClass' => '',
                'location_json' => '{"latitude":59.403648,"longitude":56.811722,"zoom":15}',
                'markers_json' => '[{"latitude":59.403648,"longitude":56.811722,"color":"#A52A2A","title":"МАУК \"БДТ\"","subTitle":""}]',
            ],
        ],
    ],
];
