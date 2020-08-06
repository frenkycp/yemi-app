<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DateTimePicker;

/**
* @var yii\web\View $this
* @var app\models\search\ScanTemperatureSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="scan-temperature-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="panel panel-primary">
    	<div class="panel-body">
    		<div class="row">
    			<div class="col-sm-6">
    				<?= $form->field($model, 'from_time')->widget(DateTimePicker::classname(), [
						'options' => ['placeholder' => 'Enter start time ...'],
						'pluginOptions' => [
							'autoclose' => true
						]
					]); ?>
    			</div>
    			<div class="col-sm-6">
    				<?= $form->field($model, 'to_time')->widget(DateTimePicker::classname(), [
						'options' => ['placeholder' => 'Enter start time ...'],
						'pluginOptions' => [
							'autoclose' => true
						]
					]); ?>
    			</div>
    		</div>
    	</div>
    	<div class="panel-footer">
    		<div class="form-group" style="margin-bottom: 0px;">
		        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		    </div>
    	</div>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>
