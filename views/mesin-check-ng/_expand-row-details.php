<?php
use yii\helpers\Html;

?>
<div style="margin: 15px;">
	<h4>Corrective Details <small><?= $model->mesin_nama . ' (' . $model->urutan . ')'; ?></small></h4>
	<div class="box box-success box-solid" style="display: none;">
		<div class="box-body">
			<table class="table table-bordered table-striped">
				<tr class="success">
					<th>Part</th>
					<th>Part Remark</th>
					<th>Repair Note</th>
					<th style="text-align: center;">Prepare Time</th>
					<th style="text-align: center;">Repair Time</th>
					<th style="text-align: center;">Sparepart Time</th>
					<th style="text-align: center;">Install Time</th>
				</tr>
				<tr class="info">
					<td><?= $model->mesin_bagian; ?></td>
					<td><?= $model->mesin_catatan; ?></td>
					<td><?= $model->repair_note; ?></td>
					<td style="text-align: center;"><?= $model->prepare_time == null ? '-' : $model->prepare_time; ?></td>
					<td style="text-align: center;"><?= $model->repair_time == null ? '-' : $model->repair_time; ?></td>
					<td style="text-align: center;"><?= $model->spare_part_time == null ? '-' : $model->spare_part_time; ?></td>
					<td style="text-align: center;"><?= $model->install_time == null ? '-' : $model->install_time; ?></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="box box-success box-solid">
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
					<div class="box box-warning box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">Before</h3>
						</div>
						<div class="box-body">
							<?php
							$filename1 = $model->urutan . '_1.jpg';
							$path1 = \Yii::$app->basePath . '\\web\\uploads\\NG_MNT\\' . $filename1;
							if (file_exists($path1)) {
								echo Html::img('@web/uploads/NG_MNT/' . $model->urutan . '_1.jpg', [
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
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="box box-success box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">After</h3>
						</div>
						<div class="box-body">
							<?php
							$filename2 = $model->urutan . '_2.jpg';
							$path2 = \Yii::$app->basePath . '\\web\\uploads\\NG_MNT\\' . $filename2;
							if (file_exists($path2)) {
								echo Html::img('@web/uploads/NG_MNT/' . $model->urutan . '_2.jpg', [
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
