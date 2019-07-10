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
    'page_title' => 'My Job <span class="text-green japanesse"></span>',
    'tab_title' => 'My Job',
    'breadcrumbs_title' => 'My Job'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	th, td {text-align: center; font-size: 16px;}
	");

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 60000); // milliseconds
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
					<th>Action</th>
					<th>Request for</th>
					<th>Slip Number</th>
					<th>Machine Name</th>
					<th>Model</th>
					<th>Start</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($model as $value) {
					$row_class = '';
					$disabled = false;
					$btn_start = Html::a('START', null, ['class' => 'btn btn-primary btn-sm', 'disabled' => true]);
					$btn_end = Html::a('END', null, ['class' => 'btn btn-warning btn-sm', 'disabled' => true]);
					if ($value->daparture_date == null) {
						$btn_start = Html::a('START', ['start', 'slip_id' => $value->slip_id], ['class' => 'btn btn-primary btn-sm']);
					} else {
						$row_class = 'success';
					}
					if ($value->arrival_date == null && $value->daparture_date != null) {
						$btn_end = Html::a('END', ['end', 'slip_id' => $value->slip_id], ['class' => 'btn btn-warning btn-sm']);
					}
					echo '<tr class="' . $row_class . '">
						<td>' . $btn_start . '&nbsp;&nbsp;&nbsp;' . $btn_end . '</td>
						<td>' . date('Y-m-d H:i', strtotime($value->request_date)) . '</td>
						<td>' . $value->slip_id . '</td>
						<td>' . $value->item . ' - ' . $value->item_desc . '</td>
						<td>' . $value->model . '</td>
						<td>' . $value->daparture_date . '</td>
					</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>