<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
use app\models\SernoInput;
use app\models\HakAkses;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * 
 */
class DprLineEfficiencyMonthlyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$line_arr = $this->getLineArr();
		$line = $line_arr[0];
		$year = date('Y');
		$month = date('m');
		

		if (\Yii::$app->request->get('line') !== null) {
			$line = \Yii::$app->request->get('line');
		}

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		$period = $year . $month;

		$line_dropdown = ArrayHelper::map($data_arr = HakAkses::find()
		->where(['level_akses' => '4'])
		->orderBy('hak_akses')
		->all(), 'hak_akses', 'hak_akses');

		$eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
	    	'period' => $period,
	    	'line' => $line
	    ])
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $target_eff_arr = \Yii::$app->params['line_eff_target'];
	    $target_eff = 100;
	    if (isset($target_eff_arr[$line])) {
	    	$target_eff = $target_eff_arr[$line];
	    }

	    $losstime_arr = SernoLosstime::find()
	    ->select([
	    	'proddate',
	    	'losstime' => 'ROUND(SUM(losstime), 2)',
	    ])
	    ->where([
	    	'extract(year_month from proddate)' => $period,
	    	'line' => $line
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->andWhere(['<>', 'category', 'CANCELED'])
	    ->groupBy('proddate')
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $tmp_data_losstime = [];
	    foreach ($losstime_arr as $losstime) {
	    	$proddate = (strtotime($losstime['proddate'] . " +7 hours") * 1000);
	    	$tmp_data_losstime[] = [
	    		'x' => $proddate,
	    		'y' => (float)$losstime['losstime'],
	    		'url' => Url::to(['get-losstime-detail', 'line' => $line, 'proddate' => $losstime['proddate']])
	    	];
	    }

	    $losstime_category_arr = SernoLosstime::find()
	    ->select([
	    	'category',
	    	'losstime' => 'ROUND(SUM(losstime), 2)',
	    	'total_category' => 'COUNT(losstime)'
	    ])
	    ->where([
	    	'extract(year_month from proddate)' => $period,
	    	'line' => $line
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->andWhere(['<>', 'category', 'CANCELED'])
	    ->groupBy('category')
	    ->orderBy('losstime DESC')
	    ->all();

	    foreach ($losstime_category_arr as $key => $value) {
	    	$tmp_category = $value->category;
	    	if ($tmp_category == 'CH') {
	    		$tmp_category = 'WIP';
	    	}
	    	$categories_losstime_category[] = $tmp_category;
	    	$tmp_data_losstime_category[] = [
	    		'y' => $value->losstime,
	    		'qty' => $value->total_category,
	    		'url' => Url::to(['get-losstime-category-detail', 'period' => $period, 'category' => $value->category, 'line' => $line])
	    	];
	    }

	    $tmp_data = [];
	    $categories = [];
	    $max = 100;
	    foreach ($eff_data_arr as $eff_data) {
	    	$proddate = (strtotime($eff_data['proddate'] . " +7 hours") * 1000);
	    	$categories[] = $eff_data['proddate'];
	    	$tmp_data[] = [
	    		'x' => $proddate,
	    		'y' => (float)round($eff_data['efficiency']),
		    	'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $eff_data['proddate']])
	    	];
	    	if ($eff_data['efficiency'] > $max) {
	    		$max = round(1.1 * $eff_data['efficiency']);
	    	}
	    }

	    $data1[] = [
	    	'name' => 'Line Efficiency',
	    	'data' => $tmp_data,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    ];

	    $data2[] = [
	    	'name' => 'Loss Time by Line',
	    	'data' => $tmp_data_losstime,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    ];

	    $data3[] = [
	    	'name' => 'Loss Time by Category',
	    	'data' => $tmp_data_losstime_category,
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    ];

	    $wt_vs_lt = SernoLosstime::find()
	    ->select([
	    	'line', 'proddate',
	    	'cm_losstime' => 'SUM(CASE WHEN category = \'CM\' THEN IFNULL(ROUND( losstime / mp), 0) ELSE 0 END)',
	    	'other_losstime' => 'SUM(CASE WHEN category != \'CM\' THEN IFNULL(ROUND( losstime / mp), 0) ELSE 0 END)'
	    ])
	    ->where([
	    	'line' => $line,
	    	'extract(year_month from proddate)' => $period
	    ])
	    ->groupBy('line, proddate')
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $wtlt_arr = $cm_losstime = $other_losstime = [];
	    foreach ($wt_vs_lt as $key => $value) {
	    	$proddate = (strtotime($value['proddate'] . " +7 hours") * 1000);
	    	$cm_losstime[] = [
	    		'x' => $proddate,
	    		'y' => $value['cm_losstime'] == 0 ? null : (float)$value['cm_losstime'],
	    	];
	    	$other_losstime[] = [
	    		'x' => $proddate,
	    		'y' => $value['other_losstime'] == 0 ? null : (float)$value['other_losstime'],
	    	];
	    }

	    $tmp_working_time = SernoInput::find()
	    ->select([
	    	'proddate',
	    	'wrk_time' => 'SUM(wrk_time)'
	    ])
	    ->where([
	    	'line' => $line,
	    	'extract(year_month from proddate)' => $period
	    ])
	    ->groupBy('proddate')
	    ->orderBy('proddate')
	    ->asArray()
	    ->all();

	    $working_time_arr = [];
	    foreach ($tmp_working_time as $key => $value) {
	    	$proddate = (strtotime($value['proddate'] . " +7 hours") * 1000);
	    	$working_time_arr[] = [
	    		'x' => $proddate,
	    		'y' => (float)round($value['wrk_time']),
	    	];
	    }

	    $wtlt_arr = [
	    	[
	    		'name' => 'CM Loss Time',
	    		'data' => $cm_losstime,
	    		'color' => \Yii::$app->params['bg-blue']
	    	],
	    	[
	    		'name' => 'Other Loss Time',
	    		'data' => $other_losstime,
	    		'color' => \Yii::$app->params['bg-red']
	    	],
	    	[
	    		'name' => 'Working Time',
	    		'data' => $working_time_arr,
	    		'color' => \Yii::$app->params['bg-green']
	    	],
	    ];

		return $this->render('index', [
			'data1' => $data1,
			'data2' => $data2,
			'data3' => $data3,
			'line' => $line,
			'period' => $period,
			'categories' => $categories,
			'categories_losstime_category' => $categories_losstime_category,
			'line_dropdown' => $line_dropdown,
			'year' => $year,
			'month' => $month,
			'target_eff' => $target_eff,
			'max' => $max,
			'working_time_losstime' => $wtlt_arr
		]);
	}

	public function getLineArr()
	{
		$data_arr = HakAkses::find()
		->where(['<>', 'hak_akses', 'MIS'])
		->orderBy('hak_akses')
		->all();

		$return_arr = [];

		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value->hak_akses;
		}

		return $return_arr;
	}

	public function actionGetLosstimeDetail($line, $proddate)
	{
		$losstime_detail_arr = SernoLosstime::find()
	    ->where([
	    	'proddate' => $proddate,
	    	'line' => $line
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->orderBy('category, start_time')
	    ->asArray()
	    ->all();

	    $remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Line : ' . $line . '<small><br/>(' . $proddate . ')</small></h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
	    $remark .= '<tr>
	    	<th class="text-center">Prod. Date</th>
	    	<th class="text-center">Start Time</th>
	    	<th class="text-center">End Time</th>
	    	<th class="text-center">Man Power</th>
	    	<th class="text-center">Category</th>
	    	<th class="text-center">Loss Time (min)</th>
	    	<th class="text-center">Model</th>
	    	<th>Reason</th>
	    </tr>';

	    foreach ($losstime_detail_arr as $value) {
	    	$losstime_category = $value['category'] == 'CM' ? 'CHANGE MODEL' : $value['category'];
	    	$losstime_category = $value['category'] == 'CH' ? 'WIP' : $value['category'];
    		$remark .= '<tr>
    			<td class="text-center">' . $value['proddate'] . '</td>
	    		<td class="text-center">' . $value['start_time'] . '</td>
	    		<td class="text-center">' . $value['end_time'] . '</td>
	    		<td class="text-center">' . $value['mp'] . '</td>
	    		<td class="text-center">' . $losstime_category . '</td>
	    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
	    		<td class="text-center">' . $value['model'] . '</td>
	    		<td>' . $value['reason'] . '</td>
	    	</tr>';
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}

	public function actionGetLosstimeCategoryDetail($period, $category, $line)
	{
		$losstime_detail_arr = SernoLosstime::find()
	    ->where([
	    	'extract(year_month from proddate)' => $period,
	    	'category' => $category,
	    	'line' => $line
	    ])
	    ->orderBy('line, proddate, start_time')
	    ->asArray()
	    ->all();

	    if ($category == 'CH') {
	    	$category = 'WIP';
	    }

	    $remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Category : ' . $category . '</h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
	    $remark .= '<tr>
	    	<th class="text-center">No.</th>
	    	<th class="text-center">Prod. Date</th>
	    	<th class="text-center">Start Time</th>
	    	<th class="text-center">End Time</th>
	    	<th class="text-center">Man Power</th>
	    	<th class="text-center">Line</th>
	    	<th class="text-center">Loss Time (min)</th>
	    	<th class="text-center">Model</th>
	    	<th>Reason</th>
	    </tr>';

	    $no = 1;
	    foreach ($losstime_detail_arr as $value) {
    		$remark .= '<tr>
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value['proddate'] . '</td>
	    		<td class="text-center">' . $value['start_time'] . '</td>
	    		<td class="text-center">' . $value['end_time'] . '</td>
	    		<td class="text-center">' . $value['mp'] . '</td>
	    		<td class="text-center">' . $value['line'] . '</td>
	    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
	    		<td class="text-center">' . $value['model'] . '</td>
	    		<td>' . $value['reason'] . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}