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
            'placeholder' => $this->string(255)->null()->defaultValue('')
                ->comment('URL изображения-плейсхолдера, показываемого до загрузки карты'),
            'location_json' => $this->text()->notNull()
                ->comment('JSON of Location'),
            'markers_json' => $this->text()->notNull()
                ->comment('JSON of Markers'),
        ], $this->tableOptions);
        $this->addCommentOnTable(static::TABLE_NAME, 'Яндекс карты');

        parent::safeUp();
    }

    public function safeDown(): void
    {
        parent::safeDown();
    }
}
