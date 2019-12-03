<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GojekDriverPresenceSearch $searchModel
*/

$this->title = [
    'page_title' => 'Order Information <span class="light-green japanesse">[ 切替段取り ]</span> | GO-MACHINE',
    'tab_title' => 'Order Information',
    'breadcrumbs_title' => 'Order Information'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("
	th, td {text-align: center; font-size: 16px;}
	.text-center {vertical-align: middle;}
	");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 30000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );

?>

<div class="panel panel-primary">
	<div class="panel-body no-padding">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Slip Number</th>
					<th>Machine Name</th>
					<th>Model</th>
					<th>Driver Name</th>
					<th>Request For</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($model as $value) {
					$row_class = '';
					if ($value->daparture_date != null) {
						$row_class = 'success text-green';
					}
					$request_date = '-';
					if ($value->request_date != null) {
						$request_date = date('Y-m-d', strtotime($value->request_date)) . ' <b>' . date('H:i', strtotime($value->request_date)) . '</b>';
					}
					echo '<tr class="' . $row_class . '">
						<td>' . $value->slip_id . '</td>
						<td>' . $value->item . ' - ' . $value->item_desc . '</td>
						<td>' . $value->model . '</td>
						<td>' . $value->GOJEK_DESC . '</td>
						<td>' . $request_date . '</td>
					</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>