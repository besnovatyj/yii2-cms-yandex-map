<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\migrations;

use Besnovatyj\Kernel\migration\BaseMigration;

/** 'm<YYMMDD_HHMMSS>_<Name>' */
class m241027_163300_create_yandex_map_maps_table extends BaseMigration
{
    public const string TABLE_NAME = '{{%yandex_map_maps}}';

    public function safeUp(): void
    {
        parent::safeUp();

        if ($this->existTable(static::TABLE_NAME)) {
            return;
        }

        $this->createTable(static::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->defaultValue('Введите название карты')
                ->comment('Название карты'),
            'cssClass' => $this->string(255)->null()
                ->comment('Стили для главного тега карты'),
            'location_json' => $this->text()->notNull()
                ->comment('JSON of Location'),
            'markers_json' => $this->text()->notNull()
                ->comment('JSON of Markers'),
        ], $this->tableOptions);
        $this->addCommentOnTable(static::TABLE_NAME, 'Яндекс карты');

        $this->batchInsert(static::TABLE_NAME,
            ['id', 'name', 'cssClass', 'location_json', 'markers_json'],
            [
                [
                    '1',
                    'МАУК "БДТ"',
                    '',
                    '{"latitude":59.403648,"longitude":56.811722,"zoom":15}',
                    '[{"latitude":59.403648,"longitude":56.811722,"color":"#A52A2A","title":"МАУК \\"БДТ\\"","subTitle":""}]',
                ],
                [
                    '2',
                    'МАУК "БДТ" 2',
                    '',
                    '{"latitude":59.403648,"longitude":56.811722,"zoom":15}',
                    '[{"latitude":59.403648,"longitude":56.811722,"color":"#A52A2A","title":"МАУК \"БДТ\"","subTitle":""}]',
                ],
            ]
        );

        parent::safeUp();
    }

    public function safeDown(): void
    {
        parent::safeDown();
    }
}
