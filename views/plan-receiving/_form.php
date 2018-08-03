<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use app\models\Vehicle;
use app\models\ItemUnit;

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

    <?= $form->field($model, 'vendor_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'container_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle')->dropDownList($vehicle_list) ?>

    <?= $form->field($model, 'item_type')->dropDownList($unit_list) ?>

    <?= $form->field($model, 'qty')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'urgent_status')->dropDownList([
        0 => 'NORMAL',
        1 => 'URGENT'
    ]) ?>

    <?= $form->field($model, 'receiving_date')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ]
    ])->label('Plan Date') ?>
    <?= $form->field($model, 'eta_yemi_date')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ]
    ])->label('ETA YEMI Date') ?>
    <?= $form->field($model, 'unloading_date')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ]
    ]) ?>
    <?= $form->field($model, 'completed_date')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ]
    ]) ?>

    <div class="form-group">
        <div class="col-sm-6 col-sm-offset-3">
            <?= Html::a('Cancel', ['plan-receiving/index'], ['class' => 'btn btn-warning pull-right', 'style' => 'margin: 0px 0px 0px 10px;']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-right']) ?>

        </div>
       
    </div>

    <?php ActiveForm::end(); ?>

</div>
