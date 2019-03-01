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
    'page_title' => 'Order Information <span class="text-green japanesse"></span>',
    'tab_title' => 'Order Information',
    'breadcrumbs_title' => 'Order Information'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }
	th, td {text-align: center; font-size: 16px;}
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
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($model as $value) {
					$row_class = '';
					if ($value->daparture_date != null) {
						$row_class = 'success';
					}
					echo '<tr class="' . $row_class . '">
						<td>' . $value->slip_id . '</td>
						<td>' . $value->item . ' - ' . $value->item_desc . '</td>
						<td>' . $value->model . '</td>
						<td>' . $value->GOJEK_DESC . '</td>
					</tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>