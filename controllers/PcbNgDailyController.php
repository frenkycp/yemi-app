<?php
namespace app\controllers;

use yii\web\Controller;

use yii\helpers\Url;

use app\models\PcbNgDaily;
use app\models\MasalahPcb;

class PcbNgDailyController extends Controller
{
	public function actionIndex()
	{
		$data = [];
		$year = '2019';
		$month = '05';

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

		$period = $year . $month;

		$ng_daily = PcbNgDaily::find()
		->where([
			'period' => $period
		])
		->all();

		/*$ng_daily = MasalahPcb::find()
		->select([
			'post_date' => 'date(created_date)',
			'line_pcb'
		])
		->where([
			'EXTRACT(year_month FROM created_date)' => $period
		])
		->groupBy('post_date, line_pcb')
		->all();*/

		$pcb_line_arr = $this->getLineArr();
		print_r($pcb_line_arr);

		foreach ($ng_daily as $key => $value) {
			$post_date = (strtotime($value->post_date . " +7 hours") * 1000);
			$tmp_data[] = [
				'x' => $post_date,
				'y' => (int)$value->total,
				'url' => Url::to(['get-remark', 'post_date' => $value->post_date]),
			];
		}

		$data = [
			[
				'name' => 'Total NG',
				'data' => $tmp_data
			],
		];

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function getLineArr()
	{
		$tmp_data = MasalahPcb::find()
		->where('line_pcb IS NOT NULL')
		->andWhere(['<>', 'line_pcb', ''])
		->groupBy('line_pcb')
		->orderBy('line_pcb')
		->all();

		$data_arr = [];

		foreach ($tmp_data as $key => $value) {
			$data_arr[] = $value->line_pcb;
		}

		return $data_arr;
	}

	public function actionGetRemark($post_date)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>NG Detail <small>(' . $post_date . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">Kode Laporan</th>
	    	<th class="text-center">GMC</th>
	    	<th class="text-center">PCB</th>
	    	<th class="text-center">NG Found</th>
	    	<th class="text-center">Side</th>
	    	<th class="text-center">Qty</th>
	    	<th>Problem</th>
	    	<th>Cause</th>
	    </tr>';

	    $data_arr = MasalahPcb::find()
	    ->where([
	    	'date(created_date)' => $post_date,
	    ])
	    ->orderBy('created_date')
	    ->all();

	    foreach ($data_arr as $key => $value) {
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $value->kode_laporan_pcb . '</td>
	    		<td class="text-center">' . $value->kode_gmc . '</td>
	    		<td class="text-center">' . $value->pcb . '</td>
	    		<td class="text-center">' . $value->ng_found . '</td>
	    		<td class="text-center">' . $value->side . '</td>
	    		<td class="text-center">' . $value->qty_pcb . '</td>
	    		<td>' . $value->problem_pcb . '</td>
	    		<td>' . $value->cause_pcb . '</td>
	    	</tr>';
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}