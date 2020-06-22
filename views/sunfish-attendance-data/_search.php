<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/**
* @var yii\web\View $this
* @var app\models\search\SernoInputSearch $model
* @var yii\widgets\ActiveForm $form
*/


/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>

<div class="serno-input-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    //'layout' => 'horizontal',
    'fieldConfig' => [
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            //'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-7',
        ],
    ],
    //'options' => ['class' => 'form-horizontal'],
    ]); ?>
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'post_date')->textInput()->label('Tanggal'); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'shift')->dropDownList([
                        1 => 1,
                        2 => 2,
                        3 => 3,
                    ], [
                        'prompt' => 'Pilih...'
                    ])->label('Shift'); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'cost_center')->dropDownList(\Yii::$app->params['sunfish_cost_center'], [
                        'prompt' => 'Pilih...'
                    ])->label('Section'); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'attend_judgement')->dropDownList([
                        'A' => 'Alpa',
                        'I' => 'Ijin',
                        'S' => 'Sakit',
                        'P' => 'Hadir',
                        'C_ALL' => 'Cuti',
                    ], [
                        'prompt' => 'Pilih...'
                    ])->label('Kehadiran'); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'come_late')->dropDownList([
                        1 => 'Y',
                        0 => 'N'
                    ], [
                        'prompt' => 'Pilih...'
                    ])->label('Terlambat'); ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'emp_no')->textInput()->label('NIK'); ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-sm-12">
                    
                    <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary']) ?>
                    <?= ''; //Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
                
                </div>
                
            </div>
        </div>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
