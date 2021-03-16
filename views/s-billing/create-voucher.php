<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\widgets\DateTimePicker;
use kartik\depdrop\DepDrop;

$this->title = Yii::t('models', 'Create Voucher');

$this->registerJs("
	function change(){
		var selectValue = $('#supplier-id').val();            
        $('#invoice_no').empty();
		$.post( '" . \Yii::$app->urlManager->createUrl('s-billing/get-invoice-by-supplier?supplier_name=') . "'+selectValue,
            function(data){
                $('#invoice_no').html(data);
            }
        );
	}
	$(document).ready(function() {
    	$('#supplier-id').change(function(){
    		change();
		});
	});
");
?>

<?php $form = ActiveForm::begin([
'id' => 'Menu',
//'layout' => 'horizontal',
'enableClientValidation' => true,
'options' => ['enctype' => 'multipart/form-data'],
'errorSummaryCssClass' => 'error-summary alert alert-error'
]
);
?>
<div class="row">
	<div class="col-sm-3">
		<?= $form->field($model, 'voucher_no')->textInput(); ?>
	</div>
	<div class="col-sm-6">
		<?php
		echo $form->field($model, 'attachment_file')->widget(\kartik\file\FileInput::className(), [
            'pluginOptions' => [
                'showCaption' => true,
		        'showRemove' => false,
		        'showUpload' => false,
		        'showPreview' => false,
		        'browseClass' => 'btn btn-primary btn-block',
		        'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
		        'browseLabel' =>  ' Select File'
            ],
            'options' => ['accept' => 'pdf']
        ]);
        ?>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<?= $form->field($model, 'supplier_name')->dropDownList($tmp_supplier_dropdown, [
			'id'=>'supplier-id',
			'prompt' => 'Select Supplier...'
		]); ?>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<?= $form->field($model, 'invoice_no')->widget(Select2::classname(), [
		    'data' => [],
		    'options' => [
		    	'placeholder' => 'Select invoice ...',
		    	'id' => 'invoice_no'
		    ],
		    'pluginOptions' => [
		        'allowClear' => true,
		        'multiple' => true
		    ],
		]); ?>
	</div>
</div>

<?= Html::a(
'Cancel',
\yii\helpers\Url::previous(),
['class' => 'btn btn-warning']) ?>

<?= Html::submitButton(
'<span class="glyphicon glyphicon-check"></span> ' .
($model->isNewRecord ? 'Create' : 'Submit'),
[
'id' => 'save-' . $model->formName(),
'class' => 'btn btn-success'
]
);
?>

<?php ActiveForm::end(); ?>