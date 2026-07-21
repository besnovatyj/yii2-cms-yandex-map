<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\entities\Marker;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $map Map */

$this->title = $map->name;
$this->params['breadcrumbs'][] = ['label' => 'Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$url = 'https://yandex.ru/maps/?ll=' . $map->location->getLongitude() . ',' . $map->location->getLatitude() . '&z=' . $map->location->getZoom() . '&l=map';
?>
<p>
    <?= Html::a('Update', ['update', 'id' => $map->id], ['class' => 'btn  btn-primary']) ?>
    <?= Html::a('Delete', ['delete', 'id' => $map->id], [
        'class' => 'btn  btn-danger',
        'data' => [
            'confirm' => 'Are you sure?',
            'method' => 'post',
        ],
    ]) ?>
    <a class="btn  btn-secondary" target="_blank"
       href="<?= $url; ?>">
        <i class="bi bi-eye"></i>
    </a>
</p>

<div class="card">
    <div class="card-header">Common</div>
    <div class="card-body">
        <?= DetailView::widget([
            'model' => $map,
            'attributes' => [
                'id',
                'cssClass',
                'placeholder',
                [
                    'attribute' => 'latitude',
                    'value' => $map->location->getLatitude(),
                ],
                [
                    'attribute' => 'longitude',
                    'value' => $map->location->getLongitude(),
                ],
                [
                    'attribute' => 'zoom',
                    'value' => $map->location->getZoom(),
                ],
            ],
        ]) ?>
    </div>
    <div class="card-footer clearfix"></div>
</div>

<div class="card">
    <div class="card-header">Markers</div>
    <div class="card-body">
        <?php
        $dataProvider = new ArrayDataProvider([
            'allModels' => $map->markers,
            'pagination' => [
                'pageSize' => 100,
                'pageSizeLimit' => [15, 100],
            ],
        ]);
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{summary}\n{items}",
            'columns' => [
                [
                    'attribute' => 'Title',
                    'value' => static function (Marker $marker) {
                        return $marker->getTitle();
                    },
                ],
                [
                    'attribute' => 'SubTitle',
                    'value' => static function (Marker $marker) {
                        return $marker->getSubTitle();
                    },
                ],
                [
                    'attribute' => 'Color',
                    'value' => static function (Marker $marker) {
                        return '<span style="width: 50px;height: 50px;background: ' . $marker->getColor() . ';border-radius: 50%;padding:0 11px;"></span>&nbsp;' . $marker->getColor();
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'Latitude',
                    'value' => static function (Marker $marker) {
                        return $marker->getLatitude();
                    },
                ],
                [
                    'attribute' => 'Longitude',
                    'value' => static function (Marker $marker) {
                        return $marker->getLongitude();
                    },
                ],
            ],
        ]) ?>
    </div>
    <div class="card-footer clearfix"></div>
</div>

























