<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
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

	    $target_eff_arr = [
	    	'306' => 55,
	    	'1600' => 60,
	    	'2700' => 60,
	    	'5600' => 50,
	    	'AW' => 75,
	    	'BR' => 50,
	    	'CEFINE' => 50,
	    	'DBR' => 80,
	    	'DSR' => 50,
	    	'HS' => 90,
	    	'L85' => 110,
	    	'P40' => 80,
	    	'PNT' => 50,
	    	'PTG' => 50,
	    	'SML' => 60,
	    	'SRT' => 50,
	    	'SW' => 60,
	    	'SW2' => 60,
	    	'TB' => 60,
	    	'VX' => 55,
	    	'VX2' => 55,
	    	'XXX' => 100,
	    ];
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
	    ->groupBy('category')
	    ->orderBy('losstime DESC')
	    ->all();

	    foreach ($losstime_category_arr as $key => $value) {
	    	$categories_losstime_category[] = $value->category;
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
	    	<th class="text-center">Start Time</th>
	    	<th class="text-center">End Time</th>
	    	<th class="text-center">Man Power</th>
	    	<th class="text-center">Category</th>
	    	<th class="text-center">Loss Time (min)</th>
	    	<th>Remark</th>
	    </tr>';

	    foreach ($losstime_detail_arr as $value) {
	    	$losstime_category = $value['category'] == 'CM' ? 'CHANGE MODEL' : $value['category'];
    		$remark .= '<tr>
	    		<td class="text-center">' . $value['start_time'] . '</td>
	    		<td class="text-center">' . $value['end_time'] . '</td>
	    		<td class="text-center">' . $value['mp'] . '</td>
	    		<td class="text-center">' . $losstime_category . '</td>
	    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
	    		<td>' . $value['model'] . '</td>
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
	    ->orderBy('line, start_time')
	    ->asArray()
	    ->all();

	    $remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Category : ' . $category . '</h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
	    $remark .= '<tr>
	    	<th class="text-center">No.</th>
	    	<th class="text-center">Start Time</th>
	    	<th class="text-center">End Time</th>
	    	<th class="text-center">Man Power</th>
	    	<th class="text-center">Line</th>
	    	<th class="text-center">Loss Time (min)</th>
	    	<th>Remark</th>
	    </tr>';

	    $no = 1;
	    foreach ($losstime_detail_arr as $value) {
    		$remark .= '<tr>
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value['start_time'] . '</td>
	    		<td class="text-center">' . $value['end_time'] . '</td>
	    		<td class="text-center">' . $value['mp'] . '</td>
	    		<td class="text-center">' . $value['line'] . '</td>
	    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
	    		<td>' . $value['model'] . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}