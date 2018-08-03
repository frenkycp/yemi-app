<?php
use yii\helpers\Html;

?>
<div style="margin: 15px;">
	<h4>Corrective Details <small><?= $model->mesin_nama . ' (' . $model->urutan . ')'; ?></small></h4>
	<div class="row">
		<div class="col-md-5">
			<?php
			$filename = $model->urutan . '.jpg';
			$path = \Yii::$app->basePath . '\\web\\uploads\\NG_MNT\\' . $filename;
			if (file_exists($path)) {
				echo Html::img('@web/uploads/NG_MNT/' . $model->urutan . '.jpg', [
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
		<div class="col-md-7">
			<div class="panel panel-info">
				<div class="panel-body">
					<table class="table table-bordered table-striped">
						<tr class="success">
							<th style="text-align: center;">Prepare Time</th>
							<th style="text-align: center;">Repair Time</th>
							<th style="text-align: center;">Sparepart Time</th>
							<th style="text-align: center;">Install Time</th>
						</tr>
						<tr class="info">
							<td style="text-align: center;"><?= $model->prepare_time == null ? '-' : $model->prepare_time; ?></td>
							<td style="text-align: center;"><?= $model->repair_time == null ? '-' : $model->repair_time; ?></td>
							<td style="text-align: center;"><?= $model->spare_part_time == null ? '-' : $model->spare_part_time; ?></td>
							<td style="text-align: center;"><?= $model->install_time == null ? '-' : $model->install_time; ?></td>
						</tr>
					</table>
					<hr>
					<dl>
						<dt>Part</dt>
						<dd><?= $model->mesin_bagian; ?></dd>
						<br/>
						<dt>Part Remark</dt>
						<dd><?= $model->mesin_catatan; ?></dd>
						<br/>
						<dt>Repair Note</dt>
						<dd><?= $model->repair_note; ?></dd>
					</dl>
					
				</div>
			</div>
			
		</div>
	</div>
</div>
