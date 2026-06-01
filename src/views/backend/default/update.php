<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\forms\backend\MapForm;
use yii\web\View;

/* @var View $this */
/* @var Map $map */
/* @var MapForm $model */

$this->title = 'Update map: ' . $map->name;
$this->params['breadcrumbs'][] = ['label' => 'Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $map->name, 'url' => ['view', 'id' => $map->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_form', [
    'model' => $model,
    'map' => $map,
]) ?>
