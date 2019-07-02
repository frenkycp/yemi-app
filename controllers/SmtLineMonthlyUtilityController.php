<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\web\JsExpression;
use app\models\WipEffNew10;
use app\models\WipEffNew12;

class SmtLineMonthlyUtilityController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	function actionIndex()
	{
		$data = [];
		$categories = [];
		$year = date('Y');
		$line_arr = ['01', '02'];
		$loc = 'WM03';
		$type = 1;
		$loc_dropdown = \Yii::$app->params['smt_inj_loc_arr'];

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('loc') !== null) {
			$loc = \Yii::$app->request->get('loc');
		}

		if (\Yii::$app->request->get('type') !== null) {
			$type = \Yii::$app->request->get('type');
		}

		$tmp_working_ratio = [];
		$tmp_operating_ratio = [];

		for ($i = 1; $i <= 12; $i++) { 
			$tmp_month = str_pad($i, 2, '0', STR_PAD_LEFT);
			$period = $year . $tmp_month;
			$categories[] = $period;

			if ($type == 1) {
				foreach ($line_arr as $key => $line) {
					$tmp_data = WipEffNew10::find()
					->where([
						'child_analyst' => $loc,
						'LINE' => $line,
						'period' => $period
					])
					->one();

					$working_ratio = $operating_ratio = null;
					if ($tmp_data->working_ratio != null) {
						$working_ratio = (float)$tmp_data->working_ratio;
						$operating_ratio = (float)$tmp_data->operating_ratio;
					}

					$tmp_working_ratio[$line][] = [
			    		'y' => $working_ratio,
				    	'url' => Url::to(['get-remark', 'period' => $period, 'line' => $line, 'loc' => $loc])
			    	];
			    	$tmp_operating_ratio[$line][] = [
			    		'y' => $operating_ratio,
				    	'url' => Url::to(['get-remark', 'period' => $period, 'line' => $line, 'loc' => $loc])
			    	];
				}
			} else {
				$tmp_data2 = WipEffNew12::find()
				->where([
					'child_analyst' => $loc,
					'period' => $period
				])
				->one();

				$working_ratio_all = $operating_ratio_all = null;
				if ($tmp_data2->child_analyst != null) {
					$working_ratio_all = (float)$tmp_data2->working_ratio;
					$operating_ratio_all = (float)$tmp_data2->operating_ratio;
				}

				$tmp_working_ratio['all'][] = [
		    		'y' => $working_ratio_all,
			    	'url' => Url::to(['get-remark', 'period' => $period, 'loc' => $loc])
		    	];
		    	$tmp_operating_ratio['all'][] = [
		    		'y' => $operating_ratio_all,
			    	'url' => Url::to(['get-remark', 'period' => $period, 'loc' => $loc])
		    	];
			}

		}

		if ($type == 1) {
			$data = [
				'working_ratio' => [
					[
				    	'name' => 'Line 1',
				    	'data' => $tmp_working_ratio['01'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
				    ],
				    [
				    	'name' => 'Line 2',
				    	'data' => $tmp_working_ratio['02'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
				    ],
				],
				'operation_ratio' => [
					[
				    	'name' => 'Line 1',
				    	'data' => $tmp_operating_ratio['01'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
				    ],
				    [
				    	'name' => 'Line 2',
				    	'data' => $tmp_operating_ratio['02'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[7]'),
				    ],
				],
			];
		} else {
			$data = [
				'working_ratio' => [
				    [
				    	'name' => 'ALL',
				    	'data' => $tmp_working_ratio['all'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
				    	'showInLegend' => false,
				    ],
				],
				'operation_ratio' => [
				    [
				    	'name' => 'ALL',
				    	'data' => $tmp_operating_ratio['all'],
				    	'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
				    	'showInLegend' => false,
				    ],
				],
			];
		}
		

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'loc_dropdown' => $loc_dropdown,
			'year' => $year,
			'loc' => $loc,
			'type' => $type,
		]);
	}
}