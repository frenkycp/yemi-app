<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\GoSaTblSearch $searchModel
*/

$this->title = Yii::t('models', 'Go Sa Tbls');
$this->params['breadcrumbs'][] = $this->title;

$this->title = [
    'page_title' => 'GO Sub Assy Data <span class="japanesse text-green"></span>',
    'tab_title' => 'GO Sub Assy Data',
    'breadcrumbs_title' => 'GO Sub Assy Data'
];
$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

date_default_timezone_set('Asia/Jakarta');

$script = "
    window.onload = setupRefresh;

    function setupRefresh() {
      setTimeout(\"refreshPage();\", 10000); // milliseconds
    }
    function refreshPage() {
       window.location = location.href;
    }
";
$this->registerJs($script, View::POS_HEAD );
?>
<div class="panel panel-primary">
	<div class="panel-body">
		<table class="table table-responsive table-bordered table-striped">
			<thead>
				<tr style="font-size: 20px;">
					<th class="text-center">No.</th>
					<th>Remark</th>
					<th>MP</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (count($data_table) == 0) {
					echo '<tr style="font-size: 20px;">
						<td colspan=4>There is no outstanding data ...</td>
					</tr>';
				} else {
					$no = 1;
					foreach ($data_table as $key => $value) {
						?>
						<tr style="font-size: 20px;">
							<td class="text-center"><?= $no; ?></td>
							<td><?= $value['REMARK']; ?></td>
							<td><?= $value['TOTAL_MP']; ?></td>
							<td width="10%">
								<?php
								if ($value['STATUS'] == 0) {
									echo Html::a('START', ['start', 'session_id' => $value['ID']], [
										'class' => 'btn btn-success btn-block',
										'data' => [
											'confirm' => 'Are you sure to START this item ?'
										],
									]);
								} else {
									echo Html::a('END', ['end', 'session_id' => $value['ID']], [
										'class' => 'btn btn-warning btn-block',
										'data' => [
											'confirm' => 'Are you sure to END this item ?'
										],
									]);
								}
								?>
							</td>
						</tr>
					<?php 
					$no++;
					}
				
				}
				?>
			</tbody>
		</table>
	</div>
</div>
