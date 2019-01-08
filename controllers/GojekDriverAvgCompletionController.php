<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekView02;
use app\models\GojekTbl;
use app\models\GojekOrderTbl;
use yii\helpers\Url;

/**
 * 
 */
class GojekDriverAvgCompletionController extends Controller
{
	public function actionIndex()
	{
		$data = [];
		$categories = [];
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

		$tmp_driver_arr = GojekTbl::find()
		->where(['<>', 'TERMINAL', 'Z'])
		->orderBy('GOJEK_DESC')
		->all();

		$gojek_data_arr = GojekView02::find()
		->select([
			'GOJEK_ID',
			'GOJEK_DESC',
			'AVERAGE_ORDER_COMPLETION' => 'ROUND(AVG(AVERAGE_ORDER_COMPLETION),0)'
		])
		->where([
			'ISSUE_PERIOD' => $period
		])
		->groupBy('GOJEK_ID, GOJEK_DESC')
		->orderBy('GOJEK_DESC')
		->all();

		foreach ($tmp_driver_arr as $tmp_driver) {
			$categories[] = $tmp_driver->GOJEK_DESC;
			$tmp_avg = null;
			foreach ($gojek_data_arr as $gojek_data) {
				if ($tmp_driver->GOJEK_ID == $gojek_data->GOJEK_ID) {
					$tmp_avg = (int)$gojek_data->AVERAGE_ORDER_COMPLETION;
				}
			}
			$tmp_data[] = [
				'y' => $tmp_avg,
				'url' => Url::to(['get-remark', 'nik' => $tmp_driver->GOJEK_ID, 'driver_name' => $tmp_driver->GOJEK_DESC, 'period' => $period])
			];
		}

		

		$data[] = [
			'name' => 'One Job Completion Time (AVG)',
			'data' => $tmp_data
		];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetRemark($nik, $driver_name, $period)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Driver : ' . $driver_name . '<small> (' . $nik . ')</small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed" style="font-size: 12px;">';
	    $remark .= '<tr>
	    	<th class="text-center">Post Date</th>
	    	<th class="text-center">Slip Num.</th>
	    	<th class="text-center">Part Num.</th>
	    	<th>Part Name</th>
	    	<th class="text-center">From</th>
	    	<th class="text-center">To</th>
	    	<th class="text-center">LT (min)</th>
	    </tr>';

	    $data_arr = GojekOrderTbl::find()
	    ->where([
	    	'GOJEK_ID' => $nik,
	    	'FORMAT(daparture_date, \'yyyyMM\')' => $period
	    ])
	    ->orderBy('LT DESC')
	    ->asArray()
	    ->all();

	    foreach ($data_arr as $value) {
    		$remark .= '<tr>
	    		<td class="text-center">' . date('Y-m-d', strtotime($value['post_date'])) . '</td>
	    		<td class="text-center">' . $value['slip_id'] . '</td>
	    		<td class="text-center">' . $value['item'] . '</td>
	    		<td>' . $value['item_desc'] . '</td>
	    		<td class="text-center">' . $value['from_loc'] . '</td>
	    		<td class="text-center">' . $value['to_loc'] . '</td>
	    		<td class="text-center">' . $value['LT'] . '</td>
	    	</tr>';
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}