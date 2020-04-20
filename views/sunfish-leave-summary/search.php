<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var app\models\search\LiveCookingDataSearch $model
* @var yii\widgets\ActiveForm $form
*/

$this->registerCss(".form-group { margin-bottom: 0px; }");

?>

<div class="live-cooking-request-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    <div class="row">
    	<div class="col-md-12">
    		<div class="box box-primary box-solid">
				<div class="box-header">
					<h3 class="box-title">
						Filter Form
					</h3>
				</div>
		        <div class="box-body">
		            <div class="row">
					    <div class="col-md-3">
		                	<?= $form->field($model, 'leave_code')->dropDownList([
		                		'ANL' => 'Annual Leave',
		                		'LONG' => 'Long Leave'
		                	], [
		                		'prompt' => 'Choose...'
		                	]); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'emp_no')->textInput()->label('NIK'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'valid_date')->textInput(); ?>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
						        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']); ?>
						    </div>
		                </div>
		            </div>
		        </div>
		    </div>
    	</div>
    </div>
	

    

    <?php ActiveForm::end(); ?>

</div>
