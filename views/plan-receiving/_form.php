<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Vehicle;
use app\models\ItemUnit;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\PlanReceiving */
/* @var $form yii\widgets\ActiveForm */

$vehicle_list = ArrayHelper::map(Vehicle::find()->where(['flag' => 1])->orderBy('name ASC')->all(), 'name', 'name');

$unit_list = ArrayHelper::map(ItemUnit::find()->where(['flag' => 1])->orderBy('name ASC')->all(), 'name', 'name');
?>

<div class="plan-receiving-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
    ]); ?>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Input Form</h3>
        </div>
        <div class="box-body">
            <div class="row" style="">
                <div class="col-sm-6">
                    <?= $form->field($model, 'vendor_name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'container_no')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'vehicle')->dropDownList($vehicle_list) ?>

                    <?= $form->field($model, 'item_type')->dropDownList($unit_list) ?>

                    <?= $form->field($model, 'qty')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'urgent_status')->dropDownList([
                        0 => 'NORMAL',
                        1 => 'URGENT'
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'receiving_date')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ])->label('Plan Date'); ?>

                    <?= $form->field($model, 'eta_yemi_date')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'cut_off_date')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'etd_port_date')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'eta_port_date')->widget(DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'bl_no')->textInput(['maxlength' => true])->label('BL No.') ?>

                    <?= ''; $form->field($model, 'unloading_time')->widget(TimePicker::classname(), [
                        'value'=> null,
                        'pluginOptions' => [
                            'showSeconds' => true,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ],

                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="pull-right">
                    <?= Html::a('Cancel', ['plan-receiving/index'], ['class' => 'btn btn-warning pull-right', 'style' => 'margin: 0px 20px 0px 10px;']) ?>
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>

                </div>
               
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
