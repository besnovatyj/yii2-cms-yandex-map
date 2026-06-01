<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\YandexMap\forms\backend\MapForm;
use yii\web\View;

/* @var $this View */
/* @var $model MapForm */

$this->title = 'Create map';
$this->params['breadcrumbs'][] = ['label' => 'Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
