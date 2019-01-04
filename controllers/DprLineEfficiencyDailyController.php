<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
use app\models\SernoInput;
use app\models\HakAkses;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;

class DprLineEfficiencyDailyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$data = [];
		$data_losstime = [];
		$categories = $this->getLineArr();

		$model = new \yii\base\DynamicModel([
	        'proddate'
	    ]);
	    $model->addRule('proddate', 'required')
	    ->addRule('proddate', 'string');

	    $model->proddate = date('Y-m-d');

	    if($model->load(\Yii::$app->request->get())){
	        
	    }

	    $tmp_data = [];
	    $eff_data_arr = SernoInput::find()
	    ->select([
	    	'line',
	    	'qty_time' => 'ROUND(SUM(qty_time),2)',
	    	'mp_time' => 'ROUND(SUM(mp_time),2)',
	    ])
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->groupBy('line')
	    ->asArray()
	    ->all();

	    $losstime_arr = SernoLosstime::find()
	    ->select([
	    	'line',
	    	'category',
	    	'losstime' => 'ROUND(SUM(losstime), 2)'
	    ])
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->groupBy('line, category')
	    ->asArray()
	    ->all();

	    $tmp_losstime_category = [];
	    foreach ($losstime_arr as $value) {
	    	if (!isset($tmp_losstime_line[$value['line']])) {
	    		$tmp_losstime_line[$value['line']] = 0;
	    	}
	    	if (!isset($tmp_losstime_category[$value['category']])) {
	    		$tmp_losstime_category[$value['category']] = 0;
	    	}
	    	
	    	$tmp_losstime_line[$value['line']] += $value['losstime'];
	    	$tmp_losstime_category[$value['category']] += $value['losstime'];
	    }

	    foreach ($categories as $key => $line) {
		    $eff = 0;
		    foreach ($eff_data_arr as $key2 => $value2) {
		    	if ($value2['line'] == $line && $value2['mp_time'] > 0) {
		    		$eff = round(($value2['qty_time'] / $value2['mp_time']) * 100, 2);
		    	}
		    }

		    $tmp_data_eff[$line] = $eff;

		    if (!isset($tmp_losstime_line[$line])) {
		    	$tmp_losstime_line[$line] = 0;
		    }

		    $losstime_val = 0;
		    foreach ($losstime_arr as $losstime) {
		    	if ($losstime['line'] == $line) {
		    		$losstime_val = $losstime['losstime'];
		    	}
		    }
	    }

	    asort($tmp_data_eff);
	    foreach ($tmp_data_eff as $key => $value) {
	    	$eff_categories[] = $key;
	    	$eff_final_data[] = [
	    		'y' => $value,
	    		'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $key, 'proddate' => $model->proddate])
	    	];
	    }

	    arsort($tmp_losstime_line);
	    foreach ($tmp_losstime_line as $key => $value) {
	    	$losstime_line_categories[] = $key;
	    	$losstime_line_final_data[] = [
	    		'y' => $value,
	    		'url' => Url::to(['get-losstime-detail', 'by' => 'line', 'proddate' => $model->proddate, 'category_name' => $key])
	    	];
	    }

	    arsort($tmp_losstime_category);
	    foreach ($tmp_losstime_category as $key => $value) {
	    	$losstime_category_categories[] = $key == 'CM' ? 'CHANGE MODEL' : $key;
	    	$losstime_category_final_data[] = [
	    		'y' => $value,
	    		'url' => Url::to(['get-losstime-detail', 'by' => 'category', 'proddate' => $model->proddate, 'category_name' => $key])
	    	];
	    }

	    $eff_data_series[] = [
	    	'name' => 'Line Efficiency',
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    	'data' => $eff_final_data,
	    	'cursor' => 'pointer',
            'point' => [
                'events' => [
                    'click' => new JsExpression('function(){ location.href = this.options.url; }'),
                    //'click' => new JsExpression('function(){ window.open(this.options.url); }')
                ]
            ]
	    ];

	    $losstime_line_data_series[] = [
	    	'name' => 'Loss Time by Line',
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    	'data' => $losstime_line_final_data
	    ];

	    $losstime_category_data_series[] = [
	    	'name' => 'Loss Time by Category',
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    	'data' => $losstime_category_final_data
	    ];

		return $this->render('index', [
			'eff_data_series' => $eff_data_series,
			'eff_categories' => $eff_categories,
			'losstime_line_data_series' => $losstime_line_data_series,
			'losstime_line_categories' => $losstime_line_categories,
			'losstime_category_data_series' => $losstime_category_data_series,
			'losstime_category_categories' => $losstime_category_categories,
			'data_losstime' => $data_losstime,
			'model' => $model,
			'categories' => $categories
		]);
	}

	public function getLineArr()
	{
		$data_arr = HakAkses::find()
		->where(['level_akses' => '4'])
		->andWhere(['<>', 'hak_akses', 'MIS'])
		->orderBy('hak_akses')
		->all();

		$return_arr = [];

		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value->hak_akses;
		}

		return $return_arr;
	}

	public function getDprGmcEff($proddate, $line)
	{
		$eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->all();

	    $return_arr = [];

	    foreach ($eff_data_arr as $key => $value) {
	    	$return_arr[$value->line] = $value->efficiency;
	    }

	    return $return_arr;
	}

	public function actionGetLosstimeDetail($by, $proddate, $category_name)
	{
	    if ($by == 'line') {
	    	$losstime_detail_arr = SernoLosstime::find()
		    ->where([
		    	'proddate' => $proddate,
		    	'line' => $category_name
		    ])
		    ->andWhere(['<>', 'category', 'UNKNOWN'])
		    ->orderBy('category, start_time')
		    ->asArray()
		    ->all();

		    $remark = '<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>Line : ' . $category_name . '<small> (' . $proddate . ')</small></h3>
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
	    		$remark .= '<tr>
		    		<td class="text-center">' . $value['start_time'] . '</td>
		    		<td class="text-center">' . $value['end_time'] . '</td>
		    		<td class="text-center">' . $value['mp'] . '</td>
		    		<td class="text-center">' . $value['category'] . '</td>
		    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
		    		<td>' . $value['model'] . '</td>
		    	</tr>';
		    }

		    $remark .= '</table>';
		    $remark .= '</div>';
	    } else {
	    	$losstime_detail_arr = SernoLosstime::find()
		    ->where([
		    	'proddate' => $proddate,
		    	'category' => $category_name
		    ])
		    ->andWhere(['<>', 'category', 'UNKNOWN'])
		    ->orderBy('line, start_time')
		    ->asArray()
		    ->all();

		    $remark = '<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3>Category : ' . $category_name . '<small> (' . $proddate . ')</small></h3>
			</div>
			<div class="modal-body">
			';

		    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
		    $remark .= '<tr>
		    	<th class="text-center">Start Time</th>
		    	<th class="text-center">End Time</th>
		    	<th class="text-center">Man Power</th>
		    	<th class="text-center">Line</th>
		    	<th class="text-center">Loss Time (min)</th>
		    	<th>Remark</th>
		    </tr>';

		    foreach ($losstime_detail_arr as $value) {
	    		$remark .= '<tr>
		    		<td class="text-center">' . $value['start_time'] . '</td>
		    		<td class="text-center">' . $value['end_time'] . '</td>
		    		<td class="text-center">' . $value['mp'] . '</td>
		    		<td class="text-center">' . $value['line'] . '</td>
		    		<td class="text-center">' . number_format($value['losstime'], 2) . '</td>
		    		<td>' . $value['model'] . '</td>
		    	</tr>';
		    }

		    $remark .= '</table>';
		    $remark .= '</div>';
	    }

	    return $remark;
	}
}