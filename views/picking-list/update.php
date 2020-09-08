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
    'page_title' => null,
    'tab_title' => 'Picking List Update',
    'breadcrumbs_title' => 'Picking List Update'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
");

date_default_timezone_set('Asia/Jakarta');

$this->registerCssFile('@web/css/dataTables.bootstrap.css');
$this->registerJsFile('@web/js/jquery.dataTables.min.js');
$this->registerJsFile('@web/js/dataTables.bootstrap.min.js');

$this->registerJs("$(document).ready(function() {
    $('#setlist-tbl').DataTable({
        'pageLength': 25,
        'sScrollX': '100%',
        'sScrollXInner': '100%',
        'order': [[13, 'desc' ], [5, 'asc' ], [6, 'asc' ], [7, 'asc' ]]
    });
});");

?>

<?php $form = ActiveForm::begin([
    'method' => 'get',
    //'layout' => 'horizontal',
    'action' => Url::to(['update']),
]); ?>

<div style="max-width: 500px; margin: auto;">
	<div class="row">
		<div class="col-md-12 text-center" style="font-size: 2em;">
			<b><u>PICKING LIST UPDATE FORM</u></b>
		</div>
	</div>
	<br/>
	<div class="panel panel-default">
		<div class="panel-body">
			<?= $form->field($model, 'barcode', [
				'inputOptions' => [
					'autofocus' => 'autofocus',
					'placeholder' => 'Scan barcode here...',
					'class' => 'form-control',
				]
			])->textInput()->label(false); ?>
			<?= Html::submitButton('SUBMIT', ['class' => 'btn btn-primary btn-block', 'style' => 'margin-top: 5px; margin-bottom: 5px;']); ?>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<div class="row">
					<div class="col-md-8">
						Setlist Number : <b style="letter-spacing: 5px;"><?= $setlist_no; ?></b>
					</div>
					<div class="col-md-4 text-right">
						Plan Qty : <b><?= number_format($plan_qty); ?></b>
					</div>
				</div>
			</h3>
		</div>
		<div class="panel-body no-padding">
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th class="text-center">Setlist Total</th>
						<th class="text-center">Setlist Open</th>
						<th class="text-center">Setlist Close</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center"><?= $total_setlist; ?></td>
						<td class="text-center"><?= $total_open; ?></td>
						<td class="text-center"><?= $total_close; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-body">
		<table class="table table-bordered" id="setlist-tbl" style="font-size: 12px;">
			<thead>
				<tr>
					<th class="text-center">Line</th>
					<th class="text-center">Location</th>
					<th class="text-center">Parent</th>
					<th class="">Desc</th>
					<th class="text-center">Date</th>
					<th class="text-center">PIC</th>
					<th class="text-center">Rack</th>
					<th class="text-center">Rack-Loc</th>
					<th class="text-center">Child</th>
					<th class="">Desc</th>
					<th class="text-center">UM</th>
					<th class="text-center">Pick Qty</th>
					<th class="text-center">Req. Qty</th>
					<th class="text-center">Status</th>
					<th class="text-center">Scan by ID</th>
					<th class="">Scan by Name</th>
					<th class="text-center">Scan Datetime</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ($setlist_data) {
					?>
					<?php foreach ($setlist_data as $key => $value):
						if ($value->hand_scan == 'Y') {
							if ($value->status == 'P') {
								$bg_class = 'bg-success text-yellow';
							} else {
								$bg_class = 'bg-success text-green';
							}
						} else {
							if ($value->status == 'C') {
								$bg_class = 'bg-danger text-red';
							} else {
								$bg_class = 'bg-warning text-yellow';
							}
						}
						?>
						<tr class="<?= $bg_class; ?>">
							<td class="text-center"><?= $value->no; ?></td>
							<td class="text-center"><?= $value->analyst_desc; ?></td>
							<td class="text-center"><?= $value->parent; ?></td>
							<td class=""><?= $value->parent_desc; ?></td>
							<td class="text-center"><?= date('d-M-y', strtotime($value->req_date)); ?></td>
							<td class="text-center"><?= $value->pic; ?></td>
							<td class="text-center"><?= $value->rack_no; ?></td>
							<td class="text-center"><?= $value->loc; ?></td>
							<td class="text-center"><?= $value->child; ?></td>
							<td class=""><?= $value->child_desc; ?></td>
							<td class="text-center"><?= $value->child_um; ?></td>
							<td class="text-center"><?= $value->compl_qty; ?></td>
							<td class="text-center"><?= $value->req_qty; ?></td>
							<td class="text-center"><?= $value->hand_scan == 'Y' ? 'CLOSE' : 'OPEN'; ?></td>
							<td class="text-center"><?= $value->hand_scan_user; ?></td>
							<td class=""><?= $value->hand_scan_desc; ?></td>
							<td class="text-center"><?= $value->hand_scan_datetime == null ? '-' : date('Y-m-d H:i', strtotime($value->hand_scan_datetime)); ?></td>
						</tr>
					<?php endforeach ?>
				<?php }
				?>
				
			</tbody>
		</table>
	</div>
</div>

<?php ActiveForm::end(); ?>