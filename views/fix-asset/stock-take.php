<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\date\DatePicker;

if ($model->schedule_id == null) {
	$this->title = [
	    'page_title' => 'STOCK TAKING FIXED ASSET ' . date('d M\' Y') . '<span class="japanesse light-green"></span>',
	    'tab_title' => 'STOCK TAKING FIXED ASSET',
	    'breadcrumbs_title' => 'STOCK TAKING FIXED ASSET'
	];
} else {
	$this->title = [
	    'page_title' => 'STOCK TAKING FIXED ASSET PERIOD (' . date('d M\' Y', strtotime($model->schedule_start)) . ' - ' . date('d M\' Y', strtotime($model->schedule_end)) . ')<span class="japanesse light-green"></span>',
	    'tab_title' => 'STOCK TAKING FIXED ASSET',
	    'breadcrumbs_title' => 'STOCK TAKING FIXED ASSET'
	];
}


//$this->registerCssFile("@web/css/data_table.css");
$this->registerCss("
	#dept-text {font-size: 1.2em; font-weight: bold; padding-bottom: 20px;}
	th, td {font-weight: normal; font-size: 0.9em; padding: 10px; vertical-align: middle !important; letter-spacing: 1px;}
	.date-format {min-width: 90px;}
	#stock-take-container {padding: 10px 0px 20px 0px;}
	.img-content {border: 1px solid Silver;}
	.file-zoom-content {
		height: unset !important;
	}
	");

$this->registerJs("$(function() {
   $('#btn-mapping').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show');
   });
});");

?>

<span id="dept-text">DEPARTMENT<span style="padding: 0px 30px;">:&nbsp;&nbsp;&nbsp;&nbsp;<i><?= $fixed_asset_data->cost_centre; ?></span><?= $fixed_asset_data->section_name; ?></i></span>
<?php $form = ActiveForm::begin([
			'id' => 'AssetTbl',
			//'layout' => 'horizontal',
			'enableClientValidation' => true,
			'errorSummaryCssClass' => 'error-summary alert alert-danger',
		]
		);
		?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">
					PRODUCT INFORMATION
				</h3>
			</div>
			<div class="box-body" id="prod-info-body">
				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Image</h3>
							</div>
							<div class="panel-body">
								<?php
								$filename = $fixed_asset_data->primary_picture . '.jpg';
								$path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
								if (file_exists($path1)) {
									echo $form->field($model, 'upload_file')->widget(\kartik\file\FileInput::className(), [
							            'options' => ['accept' => 'image/*'],
							            'pluginOptions' => [
							                'allowedFileExtensions' => ['jpg'],
							                //'showCaption' => false,
									        //'showRemove' => false,
									        //'showUpload' => false,
									        //'browseClass' => 'btn btn-primary btn-block',
									        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
									        //'browseLabel' =>  ' Select Photo',
									        'initialPreview'=>[
									            Html::img('@web/uploads/ASSET_IMG/' . $filename, ['width' => '100%'])
									        ],
									        'initialPreviewConfig' => [
									            ['caption' => 'Fix Asset Image'],
									        ],
									        //'initialPreviewAsData'=>true,
							            ],
							        ])->label(false);
								} else {
									echo $form->field($model, 'upload_file')->widget(\kartik\file\FileInput::className(), [
							            'options' => ['accept' => 'image/*'],
							            'pluginOptions' => [
							                'allowedFileExtensions' => ['jpg'],
							                //'showCaption' => false,
									        //'showRemove' => false,
									        //'showUpload' => false,
									        //'browseClass' => 'btn btn-primary btn-block',
									        //'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
									        //'browseLabel' =>  ' Select Photo',
									        // 'initialPreview'=>[
									        //     Html::img('@web/uploads/image-not-available.png', ['width' => '100%'])
									        // ],
									        // 'initialPreviewConfig' => [
									        //     ['caption' => 'No Image Found'],
									        // ],
									        //'initialPreviewAsData'=>true,
							            ],
							        ])->label(false);
								}
								?>
							</div>
							
						</div>
					</div>
					<div class="col-md-8">
						
						<strong>Fixed Asset ID</strong>
						<p class="text-muted">
							<?= $model->asset_id; ?>
						</p>
						
						<strong>Fixed Asset Description</strong>
						<p class="text-muted">
							<?= $model->computer_name; ?>
						</p>
						
						<strong>Qty</strong>
						<p class="text-muted">
							<?= number_format($fixed_asset_data->qty); ?>
						</p>

						<strong>PIC Name</strong>
						<p class="text-muted">
							<?= $fixed_asset_data->NAMA_KARYAWAN == null ? '<em>(Not Set)</em>' : $fixed_asset_data->NAMA_KARYAWAN; ?>
						</p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12">
						<h4>Sub Expense</h4>
						<table class="table table-responsice table-bordered table-striped">
							<thead>
								<tr class="bg-navy color-palette">
									<th class="text-center">No.</th>
									<th>Detail</th>
									<th class="text-center">Acquisition Date</th>
									<th>Vendor</th>
									<th class="text-center">Voucher Number</th>
									<th class="text-center">Payment Date</th>
									<th class="text-center">Depr. Date</th>
									<th class="text-center">Qty</th>
									<th class="text-center">Price</th>
									<th class="text-center">Currency</th>
									<th class="text-center">Rate</th>
									<th class="text-center">At Cost</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!$asset_dtr) {
									echo '<tr>
										<td colspan="12">No history data ...</td>
									</tr>';
								} else {
									$no = 1;
									foreach ($asset_dtr as $key => $value) {
										if ($value->dateacqledger == null) {
											$acq_date = '-';
										} else {
											$acq_date = date('Y-m-d', strtotime($value->dateacqledger));
										}

										if ($value->date_of_payment == null) {
											$payment_date = '-';
										} else {
											$payment_date = date('Y-m-d', strtotime($value->date_of_payment));
										}

										if ($value->depr_date == null) {
											$depr_date = '-';
										} else {
											$depr_date = date('Y-m-d', strtotime($value->depr_date));
										}

										echo '<tr>
											<td class="text-center">' . $value->fixed_asset_subid . '</td>
											<td>' . $value->description . '</td>
											<td class="text-center date-format">' . $acq_date . '</td>
											<td>' . $value->vendor . '</td>
											<td class="text-center">' . $value->voucher_number . '</td>
											<td class="text-center date-format">' . $payment_date . '</td>
											<td class="text-center date-format">' . $depr_date . '</td>
											<td class="text-center">' . number_format($value->qty) . '</td>
											<td class="text-center">' . number_format($value->price_unit) . '</td>
											<td class="text-center">' . $value->currency . '</td>
											<td class="text-center">' . number_format($value->rate) . '</td>
											<td class="text-center">' . number_format($value->at_cost) . '</td>
										</tr>';
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		

		<div class="box box-success box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Stock Taking Result</h3>
			</div>
			<div class="box-body">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Location</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-5">
								<?= $form->field($model, 'from_loc')->textInput(['readonly' => true]); ?>
							</div>
							<div class="col-md-5">
								<?= $form->field($model, 'to_loc')->widget(Select2::classname(), [
			                        'data' => ArrayHelper::map(app\models\AssetLocTbl::find()
			                        	->orderBy('LOC_TYPE, LOC_GROUP_DESC, LOC_DESC')
				                        ->all(), 'LOC', 'fullDesc'),
				                        'options' => [
				                            'placeholder' => 'Leave empty if location doesn\'t change...',
				                        ],
				                        'pluginOptions' => [
				                            'allowClear' => true
				                        ],
			                    ]); ?>
							</div>
							<div class="col-md-2">
								<br/>
								<?= Html::button('<i class="fa fa-map-marker">&nbsp;</i> Mapping', ['class' => 'btn btn-primary btn-block', 'id' => 'btn-mapping', 'style' => 'margin-top: 4px;']); ?>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
				        <?= $form->field($model, 'posting_date')->widget(DatePicker::classname(), [
				        'options' => [
				            'type' => DatePicker::TYPE_INPUT,
				        ],
				        'pluginOptions' => [
				            'autoclose'=>true,
				            'format' => 'yyyy-mm-dd'
				        ]
				    ]); ?>
				    </div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<?= $form->field($model, 'status')->dropDownList(\Yii::$app->params['fixed_asset_status'], [
							'onchange' => '
							var dd_val = $(this).val();
							if(dd_val == "NG"){
								$("#propose_scrap_dd").removeAttr("disabled");
							} else {
								$("#propose_scrap_dd").prop("disabled", true);
								$("#propose_scrap_dd").val("N");
								$("#propose_scrap").val("N");
							}
							'
						]); ?>
					</div>
					<div class="col-md-2">
						<?= $form->field($model, 'propose_scrap_dd')->dropDownList([
							'Y' => 'Yes',
							'N' => 'No'
						], [
							'disabled' => true,
							'id' => 'propose_scrap_dd',
							'onchange' => '$("#propose_scrap").val($(this).val());'
						])->label('Propose Scrap'); ?>
						<?= $form->field($model, 'propose_scrap')->hiddenInput(['id' => 'propose_scrap'])->label(false); ?>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-2">
						<?= $form->field($model, 'label')->dropDownList([
							'Y' => 'Yes',
							'N' => 'No'
						]); ?>
					</div>
					
					<div class="col-md-10">
						<?= $form->field($model, 'note')->textInput(['placeholder' => 'Insert remark here ...'])->label('Remark'); ?>
					</div>
					<?= $form->field($model, 'NBV')->hiddenInput()->label(false); ?>
				</div>
			</div>
			<div class="box-footer">
				<?= Html::submitButton(
		        '<span class="glyphicon glyphicon-check"></span> Submit',
		        [
		        'id' => 'save-' . $model->formName(),
		        'class' => 'btn btn-success'
		        ]
		        );
		        ?>
		        &nbsp;&nbsp;
		        <?=             Html::a(
		        '<span class="fa fa-undo"></span> Cancel',
		        \yii\helpers\Url::previous(),
		        ['class' => 'btn btn-warning']) ?>
			</div>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'header' => '<h3>Mapping Location</h3>',
        'size' => 'modal-lg',
    ]);
    echo Html::img('@web/uploads/IMAGES/fix_asset_mapping_01.jpg', ['width' => '100%']);
    yii\bootstrap\Modal::end();
?>