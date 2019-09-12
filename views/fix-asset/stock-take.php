<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = [
    'page_title' => 'STOCK TAKING FIXED ASSET ' . date('d M Y') . '<span class="japanesse text-green"></span>',
    'tab_title' => 'STOCK TAKING FIXED ASSET',
    'breadcrumbs_title' => 'STOCK TAKING FIXED ASSET'
];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	#dept-text {font-size: 1.2em; font-weight: bold; padding-bottom: 20px;}
	th, td {font-weight: normal; font-size: 1.2em; padding: 10px;}
	#stock-take-container {padding: 10px 0px 20px 0px;}
	.img-content {border: 1px solid Silver;}
	");

$this->registerCssFile("@web/css/data_table.css");

?>


<span id="dept-text">DEPARTMENT<span style="padding: 0px 30px;">:&nbsp;&nbsp;&nbsp;&nbsp;<i><?= $fixed_asset_data->cost_centre; ?></span><?= $fixed_asset_data->department_name; ?></i></span>

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
						<div id="">
							<?php
							$filename = $fixed_asset_data->primary_picture . '.jpg';
							$path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
							if (file_exists($path1)) {
								echo Html::img('@web/uploads/ASSET_IMG/' . $fixed_asset_data->primary_picture . '.jpg', [
									'class' => 'media-object img-rounded img-content',
									'width' => '100%',
									//'height' => '300'
								]);
							} else {
								echo Html::img('@web/uploads/image-not-available.png', [
									'class' => 'media-object img-rounded img-content',
									'width' => '100%',
									//'height' => '350'
								]);
							}
							?>
						</div>
					</div>
					<div class="col-md-8">
						<hr>
						<strong>Fixed Asset ID</strong>
						<p class="text-muted">
							<?= $model->asset_id; ?>
						</p>
						<hr>
						<strong>Fixed Asset Description</strong>
						<p class="text-muted">
							<?= $model->computer_name; ?>
						</p>
						<hr>
						<strong>Qty</strong>
						<p class="text-muted">
							<?= number_format($fixed_asset_data->qty); ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<?php $form = ActiveForm::begin([
			'id' => 'AssetTbl',
			//'layout' => 'horizontal',
			'enableClientValidation' => true,
			'errorSummaryCssClass' => 'error-summary alert alert-danger',
		]
		);
		?>

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
							<div class="col-md-6">
								<?= $form->field($model, 'from_loc')->textInput(['readonly' => true]); ?>
							</div>
							<div class="col-md-6">
								<?= $form->field($model, 'to_loc')->textInput(['placeholder' => 'Leave empty if location doesn\'t change ...']); ?>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-2">
						<?= $form->field($model, 'status')->dropDownList(\Yii::$app->params['fixed_asset_status']); ?>
					</div>
					<div class="col-md-2">
						<?= $form->field($model, 'label')->dropDownList([
							'Y' => 'Yes',
							'N' => 'No'
						]); ?>
					</div>
					<div class="col-md-2">
						<?= $form->field($model, 'NBV')->textInput(); ?>
					</div>
					<div class="col-md-6">
						<?= $form->field($model, 'note')->textInput(['placeholder' => 'Insert remark here ...'])->label('Remark'); ?>
					</div>
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

<div id="stock-take-container" style="display: none;">
	<table class="table-fill">
		<thead class="">
			<tr>
				<th width="10%" class="text-center">Fixed Asset ID</th>
				<th>Fixed Asset Description</th>
				<th class="text-center" width="5%">Qtys</th>
				<th width="25%">Image</th>
			</tr>
		</thead>
		<tbody class="table-hover">
			<tr>
				<td class="text-center"><?= $fixed_asset_data->asset_id; ?></td>
				<td><?= $fixed_asset_data->computer_name; ?></td>
				<td class="text-center"><?= number_format($fixed_asset_data->qty); ?></td>
				<td>
					<?php
					$filename = $fixed_asset_data->primary_picture . '.jpg';
					$path1 = \Yii::$app->basePath . '\\web\\uploads\\ASSET_IMG\\' . $filename;
					if (file_exists($path1)) {
						echo Html::img('@web/uploads/ASSET_IMG/' . $fixed_asset_data->primary_picture . '.jpg', [
							'class' => 'media-object img-rounded',
							'width' => '100%',
							//'height' => '300'
						]);
					} else {
						echo Html::img('@web/uploads/image-not-available.png', [
							'class' => 'media-object img-rounded',
							'width' => '100%',
							'height' => '350'
						]);
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
</div>


