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
					'height' => '300'
				]);
			}
			?>
		</div>
		<div class="col-md-7">
			<div class="panel panel-info">
				<div class="panel-body">
					<dl>
						<dt>Part</dt>
						<dd><?= $model->mesin_bagian; ?></dd>
						<hr>
						<dt>Part Remark</dt>
						<dd><?= $model->mesin_catatan; ?></dd>
						<hr>
						<dt>Repair Note</dt>
						<dd><?= $model->repair_note; ?></dd>
					</dl>
				</div>
			</div>
			
		</div>
	</div>
</div>
