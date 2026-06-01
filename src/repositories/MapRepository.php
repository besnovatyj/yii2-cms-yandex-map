<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\repositories;

use Besnovatyj\YandexMap\entities\Map;
use RuntimeException;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

class MapRepository
{
    public function get(int $id): Map
    {
        if (!$map = Map::findOne($id)) {
            throw new NotFoundException('Map is not found.');
        }
        return $map;
    }

    public function find(int $id): ?Map
    {
        return Map::findOne($id);
    }

    /**
     * @throws Exception
     */
    public function save(Map $map): void
    {
        if (!$map->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function remove(Map $map): void
    {
        if (!$map->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }

}
