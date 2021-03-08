<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use app\models\AuditPatrolTbl;

class AuditPatrolMonitoringController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_data_patrol = AuditPatrolTbl::find()
        ->select([
        	'PATROL_DATE',
        	'total_open' => 'SUM(CASE WHEN STATUS = \'O\' THEN 1 ELSE 0 END)',
        	'total_close' => 'SUM(CASE WHEN STATUS = \'C\' THEN 1 ELSE 0 END)',
        	'total_5s' => 'SUM(CASE WHEN TOPIC = \'5S\' THEN 1 ELSE 0 END)',
        	'total_safety' => 'SUM(CASE WHEN TOPIC = \'Safety\' THEN 1 ELSE 0 END)',
        ])
        ->where([
        	'AND',
        	['>=', 'PATROL_DATE', $model->from_date],
        	['<=', 'PATROL_DATE', $model->to_date],
        ])
        ->groupBy('PATROL_DATE')
        ->orderBy('PATROL_DATE')
        ->all();

        $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
        $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

        $tmp_data_arr = [];
        $tmp_total_open = $tmp_total_close = $tmp_total_5s = $tmp_total_safety = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
        	$tgl = $i->format("Y-m-d");
        	$post_date = (strtotime($tgl . " +7 hours") * 1000);
        	$total_open = $total_close = $total_5s = $total_safety = null;

        	foreach ($tmp_data_patrol as $value) {
        		if (date('Y-m-d', strtotime($value->PATROL_DATE)) == $tgl) {
        			$total_open = $value->total_open;
        			$total_close = $value->total_close;
        			$total_5s = $value->total_5s;
        			$total_safety = $value->total_safety;

        			$tmp_total_open += $value->total_open;
        			$tmp_total_close += $value->total_close;
        			$tmp_total_5s += $value->total_5s;
        			$tmp_total_safety += $value->total_safety;
        		}
        	}

        	$tmp_data_arr['open'][] = [
        		'x' => $post_date,
                'y' => $total_open == 0 ? null : (int)$total_open,
        	];
        	$tmp_data_arr['close'][] = [
        		'x' => $post_date,
                'y' => $total_close == 0 ? null : (int)$total_close,
        	];
        	$tmp_data_arr['5s'][] = [
        		'x' => $post_date,
                'y' => $total_5s == 0 ? null : (int)$total_5s,
        	];
        	$tmp_data_arr['safety'][] = [
        		'x' => $post_date,
                'y' => $total_safety == 0 ? null : (int)$total_safety,
        	];
        }

        $data['status'][] = [
        	'name' => 'Completion Progress',
        	'data' => [
        		[
	        		'name' => 'OPEN',
	        		'y' => (int)$tmp_total_open,
	        		'color' => \Yii::$app->params['bg-red'],
	        	],
	        	[
	        		'name' => 'CLOSE',
	        		'y' => (int)$tmp_total_close,
	        		'color' => \Yii::$app->params['bg-green'],
	        	],
        	],
        ];

        $data['topic'][] = [
        	'name' => 'Completion Progress',
        	'data' => [
        		[
	        		'name' => '5S',
	        		'y' => (int)$tmp_total_5s,
	        		'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
	        	],
	        	[
	        		'name' => 'SAFETY',
	        		'y' => (int)$tmp_total_safety,
	        		'color' => new JsExpression('Highcharts.getOptions().colors[4]'),
	        	],
        	],
        ];

        $data['status_daily'] = [
        	[
        		'name' => 'OPEN',
        		'data' => $tmp_data_arr['open'],
        		'color' => \Yii::$app->params['bg-red'],
        	],
        	[
        		'name' => 'CLOSE',
        		'data' => $tmp_data_arr['close'],
        		'color' => \Yii::$app->params['bg-green'],
        	],
        ];

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}
}