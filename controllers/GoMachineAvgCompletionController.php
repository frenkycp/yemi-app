<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekView01;
use app\models\GojekTbl;
use app\models\GojekOrderTbl;
use yii\helpers\Url;

class GoMachineAvgCompletionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex($value='')
	{
		set_time_limit(300);
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
		->joinWith('gojekOrderTbl')
		->select([
			'GOJEK_TBL.GOJEK_ID',
			'GOJEK_TBL.GOJEK_DESC',
			'JOB_COUNT' => 'COUNT(id)',
			'TOTAL_LT' => 'SUM(LT)',
		])
		->where([
			'GOJEK_TBL.SOURCE' => 'MCH',
			'FORMAT(daparture_date, \'yyyyMM\')' => $period,
			'STAT' => 'C'
		])
		->andWhere(['>', 'LT', 2])
		->groupBy('GOJEK_TBL.GOJEK_ID, GOJEK_TBL.GOJEK_DESC')
		->orderBy('GOJEK_TBL.GOJEK_DESC')
		->all();

		foreach ($tmp_driver_arr as $key => $tmp_driver) {
			$categories[] = $tmp_driver->GOJEK_DESC;
			$tmp_avg = 0;
			if ($tmp_driver->JOB_COUNT > 0) {
				$tmp_avg = round($tmp_driver->TOTAL_LT / $tmp_driver->JOB_COUNT, 1);
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
	    	<th class="text-center">No.</th>
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
	    	'FORMAT(daparture_date, \'yyyyMM\')' => $period,
	    ])
	    ->andWhere('LT IS NOT NULL')
	    ->orderBy('LT DESC')
	    ->asArray()
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $value) {
    		$remark .= '<tr>
    			<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . date('Y-m-d', strtotime($value['post_date'])) . '</td>
	    		<td class="text-center">' . $value['slip_id'] . '</td>
	    		<td class="text-center">' . $value['item'] . '</td>
	    		<td>' . $value['item_desc'] . '</td>
	    		<td class="text-center">' . $value['from_loc'] . '</td>
	    		<td class="text-center">' . $value['to_loc'] . '</td>
	    		<td class="text-center">' . $value['LT'] . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}