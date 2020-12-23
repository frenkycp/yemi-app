<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use kartik\typeahead\TypeaheadBasic;
use yii\web\View;
use yii\helpers\Url;

$this->title = [
    'page_title' => 'Add Repair Serno Data Record <span class="japanesse text-green"></span>',
    'tab_title' => 'Add Repair Serno Data Record',
    'breadcrumbs_title' => 'Add Repair Serno Data Record'
];


$script = "
	$(document).ready(function() {
        $('.inputs').keydown(function (e) {
		     if (e.which === 13) {
		         var index = $('.inputs').index(this) + 1;
		         $('.inputs').eq(index).focus();
		         e.preventDefault();
		     }
		 });
    });
	
";
$this->registerJs($script, View::POS_HEAD );

$this->registerCss('
    .form-group {margin-bottom: 0px;}
');

/*echo '<pre>';
print_r($repair_pic_arr);
echo '</pre>';*/
?>

<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">NG Information</h3>
	</div>
	<div class="box-body">
		<dl class="dl-horizontal">
			<dt>Report No.</dt>
			<dd><?= $ng_data->document_no; ?></dd>
		</dl>
	</div>
</div>
<?php $form = ActiveForm::begin([
    'method' => 'post',
    //'layout' => 'horizontal',
    //'action' => Url::to(['add-multiple-serno']),
]); ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Input Form</h3>
	</div>
	<div class="panel-body">
		<table class="table table-striped table-condensed" style="margin-bottom: 0px;">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Serial Number</th>
					<th class="text-center">Repair PIC</th>
				</tr>
			</thead>
			<tbody>
				<?php
				for ($i = 1; $i <= $ng_data->ng_qty; $i++) { 
					?>
					<tr>
						<td class="text-center" style="vertical-align: middle;">
							<span>
								<?= $i; ?>
							</span>
						</td>
						<td class="text-center">
							<?= $form->field($model, 'serial_number[]')->textInput([
								'placeholder' => 'Input Serno Here ...',
								'id' => 'serial-number-' . $i,
								'class' => 'form-control inputs',
								'onkeyup' => 'this.value=this.value.toUpperCase()',
								'onfocusout' => 'this.value=this.value.toUpperCase()',
							])->label(false); ?>
						</td>
						<td>
							<?= $form->field($model, 'repair_pic[]')->widget(Select2::classname(), [
		                        'data' => $karyawan_dropdown,
		                        'options' => [
		                            'placeholder' => '- SELECT REPAIR PIC -',
		                            'id' => 'repair-pic-' . $i,
		                        ],
		                        'pluginOptions' => [
		                            'allowClear' => true,
		                        ],
		                    ])->label(false); ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		
		

		
	</div>
	<div class="panel-footer">
		<?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> Submit',
            [
            'id' => 'btn-submit',
            'class' => 'btn btn-success'
            ]
            );
            ?>
	</div>
</div>

<?php ActiveForm::end(); ?>