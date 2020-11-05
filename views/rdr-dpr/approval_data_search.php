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
    'action' => ['korlap-approval-data'],
    'method' => 'get',
    ]); ?>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">
						Filter Form
					</h3>
				</div>
		        <div class="panel-body">
		            <div class="row">
		                <div class="col-md-3">
		                	<?= $form->field($model, 'material_document_number')->textInput(); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'rcv_date')->widget(DatePicker::classname(), [
						        'options' => [
						            'type' => DatePicker::TYPE_INPUT,
						        ],
						        'pluginOptions' => [
						            'autoclose'=>true,
						            'format' => 'yyyy-mm-dd'
						        ]
						    ]); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'period')->textInput(); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'normal_urgent')->dropDownList([
		                		'NORMAL' => 'NORMAL',
		                		'URGENT' => 'URGENT',
		                	], [
		                		'prompt' => 'Choose...'
		                	]); ?>
		                </div>
		            </div>
		            <div class="row">
		            	<div class="col-md-3">
		                	<?= $form->field($model, 'material')->textInput(); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'description')->textInput(); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'vendor_code')->textInput(); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'vendor_name')->textInput(); ?>
		                </div>
		            </div>
		            <div class="row">
		            	<div class="col-md-3">
		                	<?= $form->field($model, 'status_val')->dropDownList([
		                		0 => 'Waiting Korlap Approval',
		                		1 => 'Waiting Purch. Approval',
		                	], [
		                		'prompt' => 'Choose...'
		                	])->label('Status'); ?>
		                </div>
		                <div class="col-md-3">
		                	<?= $form->field($model, 'category')->dropDownList(\Yii::$app->params['rdr_category_arr'], [
		                		'prompt' => 'Choose...'
		                	]); ?>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-sm-12">
		                    <div class="form-group">
						        <?= Html::submitButton('Search', ['class' => 'btn btn-info']); ?>
						    </div>
		                </div>
		            </div>
		        </div>
		    </div>
    	</div>
    </div>
	

    

    <?php ActiveForm::end(); ?>

</div>
