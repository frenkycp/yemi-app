<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var app\models\search\MachineIotOutputlSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="machine-iot-output-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="row">
    	<div class="col-sm-3">
    		<?= $form->field($model, 'mesin_id') ?>
    	</div>
    	<div class="col-sm-3">
    		<?= $form->field($model, 'mesin_description') ?>
    	</div>
    	<div class="col-sm-3">
    		<?= $form->field($model, 'start_date') ?>
    	</div>
    	<div class="col-sm-3">
    		<?= $form->field($model, 'end_date') ?>
    	</div>
    </div>
    <div class="row">
    	<div class="col-sm-3">
    		<?= $form->field($model, 'lot_number') ?>
    	</div>
    	<div class="col-sm-3">
    		<?= $form->field($model, 'child_analyst')->dropDownList(\Yii::$app->params['iot_location_arr'], [
			'prompt' => 'Choose location...'
		]); ?>
    	</div>
    	<div class="col-sm-6">
    		<?= $form->field($model, 'kelompok')->widget(Select2::classname(), [
	            'data' => ArrayHelper::map(app\models\MachineIotCurrent::find()->select([
	                'kelompok'
	            ])
	            ->orderBy('kelompok')
	            ->all(), 'kelompok', 'kelompok'),
	            'options' => [
	                'placeholder' => 'Choose...',
	                'multiple' => true,
	            ],
	            'pluginOptions' => [
	                'allowClear' => true,
	            ],
	        ]); ?>
    	</div>
    </div>
		
    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
