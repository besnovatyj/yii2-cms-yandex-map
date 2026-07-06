<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\Backend\Widgets\grid\ActionColumn;
use Besnovatyj\User\components\Helper;
use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\forms\backend\search\MapSearch;
use Besnovatyj\Backend\Widgets\pagination\LinkPager;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel MapSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Maps';
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?= Html::a('Create map', ['create'], ['class' => 'btn  btn-success ']) ?>
</p>

<div class="card">
    <div class="card-header"><?= $this->title ?></div>
    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}",
            'columns' => [
                [
                    'attribute' => 'name',
                    'value' => static function (Map $model) {
                        return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                ],
                'id',
                [
                    'attribute' => 'on Yandex',
                    'value' => static function (Map $model) {
                        return Html::a(
                            '<i class="bi bi-eye"></i>',
                            'https://yandex.ru/maps/?ll=' . $model->location->getLongitude() . ',' . $model->location->getLatitude() . '&z=' . $model->location->getZoom() . '&l=map',
                            ['target' => '_blank']
                        );
                    },
                    'format' => 'raw',
                ],
                ['class' => ActionColumn::class,
                    'template' => Helper::filterActionColumn(['view', 'update', 'delete',]),
                ],
            ],
        ]); ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <nav aria-label="" class="nav-pagination">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
            ]) ?>
        </nav>
    </div>
</div>
<!-- /.card -->
