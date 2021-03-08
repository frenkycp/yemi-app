<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = [
    'page_title' => 'Voucher Detail Data <span class="japanesse light-green"></span>',
    'tab_title' => 'Voucher Detail Data',
    'breadcrumbs_title' => 'Voucher Detail Data'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

?>
<?= Html::a('<i class="fa fa-arrow-circle-left"></i> Back', Url::previous(), ['class' => 'btn btn-warning', 'style' => 'margin-bottom: 10px;']); ?>
<div class="panel panel-primary">
	<div class="panel-body">
		<span style="font-size: 20px;">Voucher No. <?= $voucher_no; ?></span>
		<hr>
		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th class="text-center" width="90px">Action</th>
					<th>Supplier Name</th>
					<th class="text-center">Invoice No.</th>
					<th class="text-center">Receipt No.</th>
					<th class="text-center">Delivery No.</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($invoice_data as $invoice_val): ?>
					<tr>
						<td class="text-center">
							<?= Html::a('REMOVE', ['remove-invoice', 'no' => $no], [
								'class' => 'btn btn-danger btn-sm',
								'data-confirm' => 'Are you sure to remove this invoice number from voucher ?'
							]); ?>
						</td>
						<td class=""><?= $invoice_val->supplier_name; ?></td>
						<td class="text-center"><?= $invoice_val->invoice_no; ?></td>
						<td class="text-center"><?= $invoice_val->receipt_no; ?></td>
						<td class="text-center"><?= $invoice_val->delivery_no; ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>