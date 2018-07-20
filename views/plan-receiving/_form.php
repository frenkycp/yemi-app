<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use app\models\Vehicle;
use app\models\ItemUnit;

/* @var $this yii\web\View */
/* @var $model app\models\PlanReceiving */
/* @var $form yii\widgets\ActiveForm */

$vehicle_list = ArrayHelper::map(Vehicle::find()->orderBy('name ASC')->all(), 'name', 'name');

$unit_list = ArrayHelper::map(ItemUnit::find()->orderBy('name ASC')->all(), 'name', 'name');
?>

<div class="plan-receiving-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'vendor_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'container_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vehicle')->dropDownList($vehicle_list, ['prompt' => 'Select Vehicle...']) ?>

    <?= $form->field($model, 'item_type')->dropDownList($unit_list, ['prompt' => 'Select Unit...']) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'receiving_date')->widget(DatePicker::className(), [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
