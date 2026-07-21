<?php


/*
 * Copyright (c) 2026 Besnovatyj. Licensed under the MIT License.
 */

use Besnovatyj\YandexMap\entities\Map;
use Besnovatyj\YandexMap\forms\backend\MapForm;
use Besnovatyj\YandexMap\views\backend\default\assets\Assets;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

/* @var $this View */
/* @var $model MapForm */
/* @var $map Map */
/* @var $form ActiveForm */

// Register compiled TypeScript assets
Assets::register($this);

?>

<?php $form = ActiveForm::begin(); ?>
<div class="card">
    <div class="card-header"><?= $this->title ?></div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Map data</div>
                    <div class="card-body">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        <?= $form->field($model, 'cssClass')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>
                        <?= $form->field($model, 'placeholder')->textInput(['maxlength' => true, 'class' => 'form-control'])
                            ->hint('URL изображения-заглушки, показываемого до загрузки карты (при наведении/тапе). Пусто — без заглушки. Поддерживаются текстовые шорткоды (например, %staticHost%).') ?>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Location</div>
                    <div class="card-body">
                        <?= $form->field($model->location, 'latitude')->textInput(['class' => 'form-control']) ?>
                        <?= $form->field($model->location, 'longitude')->textInput(['class' => 'form-control']) ?>
                        <?= $form->field($model->location, 'zoom')->textInput(['class' => 'form-control']) ?>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card tabular-block">
                    <div class="card-header">Markers</div>
                    <div class="card-body tabular-rows">
                        <?php $i = 0; ?>
                        <?php foreach ($model->markers as $marker): ?>
                            <div class="row tabular-row mb-3">
                                <div class="col-md-2">
                                    <?= $form->field($marker, '[' . $i . ']latitude')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => '0.000000',
                                        'data-validation' => 'latitude'
                                    ]) ?>
                                </div>
                                <div class="col-md-2">
                                    <?= $form->field($marker, '[' . $i . ']longitude')->textInput([
                                        'class' => 'form-control',
                                        'placeholder' => '0.000000',
                                        'data-validation' => 'longitude'
                                    ]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($marker, '[' . $i . ']title')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 255,
                                        'data-validation' => 'title'
                                    ]) ?>
                                </div>
                                <div class="col-md-3">
                                    <?= $form->field($marker, '[' . $i . ']subTitle')->textInput([
                                        'class' => 'form-control',
                                        'maxlength' => 255,
                                        'data-validation' => 'subtitle'
                                    ]) ?>
                                </div>
                                <div class="col-md-1">
                                    <?= $form->field($marker, '[' . $i . ']color')->textInput([
                                        'class' => 'form-control',
                                        'type' => 'color',
                                        'data-validation' => 'color'
                                    ]) ?>
                                </div>
                                <div class="col-md-1 d-flex align-items-end gap-1">
                                    <button type="button" class="btn btn-sm btn-info tabular-autofill-btn"
                                            title="Auto-fill from Location">
                                        <i class="bi bi-stars"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger tabular-del-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php
                        //                        echo $form->field($model, 'markers')->widget(MultipleInput::class, [
                        //                            'max' => 5,
                        //                            'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        //                            'columns' => [
                        //                                [
                        //                                    'name' => 'latitude',
                        //                                    'title' => 'latitude',
                        //                                    'type' => 'textInput',
                        //                                ],
                        //                                [
                        //                                    'name' => 'longitude',
                        //                                    'title' => 'longitude',
                        //                                    'type' => 'textInput',
                        //                                ],
                        //                                [
                        //                                    'name' => 'title',
                        //                                    'title' => 'title',
                        //                                    'type' => 'textInput',
                        //                                ],
                        //                                [
                        //                                    'name' => 'subTitle',
                        //                                    'title' => 'subTitle',
                        //                                    'type' => 'textInput',
                        //                                ],
                        //                                [
                        //                                    'name' => 'color',
                        //                                    'title' => 'color',
                        //                                    'type' => 'textInput',
                        //                                ],
                        //
                        ////                        [
                        ////                            'name' => 'type',
                        ////                            'value' => static function ($data) {
                        ////                                var_dump($data);
                        ////                            },
                        ////                            'title' => 'Строка',
                        ////                            'enableError' => true,
                        ////                        ],
                        ////                        [
                        ////                            'name' => 'value',
                        ////                            'type' => \core\widgets\maskedinput\MaskedInput::class,
                        ////                            'title' => 'Сумма',
                        ////                            'enableError' => true,
                        ////                            'options' => [
                        ////                                'class' => 'form-control',
                        ////                                'clientOptions' => [
                        ////                                    'alias' => 'decimal',
                        ////                                    'rightAlign' => false,
                        ////                                    'numericInput' => true,
                        ////                                    'digits' => 2,
                        ////                                    'digitsOptional' => false,
                        ////                                    'radixPoint' => ',',
                        ////                                    'groupSeparator' => ' ',
                        ////                                    'autoGroup' => true,
                        ////                                    'removeMaskOnSubmit' => true,
                        ////                                ],
                        ////                            ]
                        ////                        ],
                        //                            ]
                        //                        ]);
                        ?>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer clearfix">
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>










