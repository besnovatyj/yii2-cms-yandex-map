<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

namespace Besnovatyj\YandexMap\services;

use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\entities\Marker;
use Besnovatyj\YandexMap\forms\backend\MapForm;
use Besnovatyj\YandexMap\repositories\MapRepository;
use Throwable;
use yii\db\Exception;
use yii\db\StaleObjectException;

class YandexMapService
{
    private MapRepository $maps;

    public function __construct(MapRepository $maps)
    {
        $this->maps = $maps;
    }

    /**
     * @throws Exception
     */
    public function create(MapForm $form): Map
    {
        $map = Map::create(
            $form->name,
            $form->cssClass,
        );

        $map->setLocation(
            $form->location->latitude,
            $form->location->longitude,
            $form->location->zoom
        );

        $map->clearMarkers();
        foreach ($form->markers as $markerForm) {
            $map->addMarker(new Marker($markerForm->latitude, $markerForm->longitude, $markerForm->color, $markerForm->title, $markerForm->subTitle,));
        }

        $this->maps->save($map);
        return $map;
    }

    /**
     * @throws Exception
     */
    public function edit(Map $map, MapForm $form): void
    {
        $map->edit(
            $form->name,
            $form->cssClass,
        );

        $map->setLocation(
            $form->location->latitude,
            $form->location->longitude,
            $form->location->zoom
        );

        $map->clearMarkers();
        foreach ($form->markers as $markerForm) {
            $map->addMarker(new Marker($markerForm->latitude, $markerForm->longitude, $markerForm->color, $markerForm->title, $markerForm->subTitle,));
        }

        $this->maps->save($map);
    }


    /**
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function remove($id): void
    {
        $map = $this->maps->get($id);
        $this->maps->remove($map);
    }

}
