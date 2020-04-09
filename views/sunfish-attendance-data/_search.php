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
                <div class="col-md-4">
                    <?= $form->field($model, 'period')->textInput()->label('Period'); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'post_date')->textInput()->label('Date'); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'emp_no')->textInput()->label('NIK'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'shiftdaily_code')->widget(Select2::classname(), [
                        'data' => [
                            'Shift_1' => 'Shift_1',
                            'Shift_1_Jumat' => 'Shift_1_Jumat',
                            'Shift_2' => 'Shift_2',
                            'Shift_3' => 'Shift_3',
                            '4G_Shift_1' => '4G_Shift_1',
                            '4G_Shift_2' => '4G_Shift_2',
                            '4G_Shift_3' => '4G_Shift_3',
                            'OFF' => 'OFF',
                        ],
                        'options' => [
                            'placeholder' => 'Choose...',
                            'multiple' => true,
                        ],
                    ])->label('Shift Code'); ?>
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
