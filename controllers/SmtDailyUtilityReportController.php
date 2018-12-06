<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\WipEffDailyUtilView;
use yii\web\JsExpression;
use app\models\WipEffView;

class SmtDailyUtilityReportController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
	public function actionIndex()
	{
		$utility_data_arr = WipEffDailyUtilView::find()
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($utility_data_arr as $key => $utility_data) {
			$proddate = (strtotime($utility_data['post_date'] . " +7 hours") * 1000);
			$tmp_data_gross[] = [
	    		'x' => $proddate,
	    		'y' => (float)$utility_data['utility_gross'],
		    	'url' => Url::to(['get-remark', 'proddate' => $utility_data['post_date']])
	    	];
	    	$tmp_data_nett[] = [
	    		'x' => $proddate,
	    		'y' => (float)$utility_data['utility_nett'],
		    	'url' => Url::to(['get-remark', 'proddate' => $utility_data['post_date']])
	    	];
		}

		$wip_eff_view = WipEffView::find()
		->orderBy('post_date, line')
		->all();

		foreach ($wip_eff_view as $key => $value) {
			if (!isset($tmp_data[$value->post_date][$value->LINE]['losstime'])) {
				$tmp_data[$value->post_date][$value->LINE]['losstime'] = 0;
			}
			$tmp_data[$value->post_date][$value->LINE]['losstime'] += $value->lt_loss;
		}

		foreach ($tmp_data as $key => $value) {
			$post_date = (strtotime($key . " +7 hours") * 1000);
			$tmp_line1[] = [
				'x' => $post_date,
				'y' => $value['01']['losstime']
			];
			$tmp_line2[] = [
				'x' => $post_date,
				'y' => $value['02']['losstime']
			];
		}

		$data2 = [
			[
				'name' => 'Line 1',
				'data' => $tmp_line1,
				'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
			],
			[
				'name' => 'Line 2',
				'data' => $tmp_line2,
				'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
			],
		];

		$data = [
			[
		    	'name' => 'SMT Utility (Gross)',
		    	'data' => $tmp_data_gross,
		    	'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
		    ],
		    [
		    	'name' => 'SMT Utility (Nett)',
		    	'data' => $tmp_data_nett,
		    	'color' => new JsExpression('Highcharts.getOptions().colors[2]'),
		    ],
		];

		return $this->render('index', [
			'data' => $data,
			'tmp_data' => $tmp_data,
			'data2' => $data2,
		]);
	}

	public function actionGetRemark($proddate)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Date : ' . $proddate . '</h3>
		</div>
		<div class="modal-body">
		';

	    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th class="text-center">No.</th>
	    	<th class="text-center">Shift</th>
	    	<th class="text-center">Line</th>
	    	<th class="text-center">Part No</th>
	    	<th>Part Description</th>
	    	<th class="text-center">Qty</th>
	    	<th class="text-center">ST</th>
	    	<th class="text-center">LT (Std)</th>
	    	<th class="text-center">LT (Gross)</th>
	    	<th class="text-center">LT (Nett)</th>
	    	<th class="text-center">Loss Time</th>
	    </tr>';

	    $utility_data_arr = WipEffView::find()
	    ->where([
	    	'CONVERT(date, post_date)' => $proddate
	    ])
	    ->orderBy('SMT_SHIFT, LINE, child_01')
	    ->all();

	    $no = 1;
	    foreach ($utility_data_arr as $key => $utility_data) {
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $utility_data->SMT_SHIFT . '</td>
	    		<td class="text-center">' . $utility_data->LINE . '</td>
	    		<td class="text-center">' . $utility_data->child_01 . '</td>
	    		<td>' . $utility_data->child_desc_01 . '</td>
	    		<td class="text-center">' . $utility_data->qty_all . '</td>
	    		<td class="text-center">' . $utility_data->std_all . '</td>
	    		<td class="text-center">' . $utility_data->lt_std . '</td>
	    		<td class="text-center">' . $utility_data->lt_gross . '</td>
	    		<td class="text-center">' . $utility_data->lt_nett . '</td>
	    		<td class="text-center">' . $utility_data->lt_loss . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}