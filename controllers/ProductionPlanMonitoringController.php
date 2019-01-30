<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;

use app\models\WipLocation;
use app\models\WipEffTbl;

class ProductionPlanMonitoringController extends Controller
{
    
    public function actionIndex()
    {
    	$this->layout = 'clean';
    	$data = [];
    	$line = '01';
    	$location = 'WM03';
        $today = date('Y-m-d');
        //$today = '2019-01-28';

    	if(\Yii::$app->request->get('location') !== null){
    		$location = \Yii::$app->request->get('location');
    	}

    	if(\Yii::$app->request->get('line') !== null){
    		$line = \Yii::$app->request->get('line');
    	}

    	$currently_running = WipEffTbl::find()
    	->where([
    		'child_analyst' => $location,
    		//'plan_date' => $today,
    		'line' => $line,
            'plan_run' => 'R'
    	])
    	->one();

        $running = [
            'lot_no' => $currently_running->lot_id == null ? '-' : $currently_running->lot_id,
            'part_no' => $currently_running->child_all == null ? '-' : $currently_running->child_all,
            'part_desc' => $currently_running->child_desc_all == null ? '-' : $currently_running->child_desc_all,
            'qty' => $currently_running->qty_all == null ? '0' : $currently_running->qty_all,
        ];

    	$location_dropdown = ArrayHelper::map(WipLocation::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc');
    	
        return $this->render('index', [
			'data' => $data,
			'line' => $line,
			'location_dropdown' => $location_dropdown,
			'location' => $location,
            'running' => $running,
            'plan_data' => $this->getPlanData($location, $line),
		]);
    }

    public function getPlanData($location, $line)
    {
        $today = date('Y-m-d');
        //$today = '2019-01-28';

        $plan_data = WipEffTbl::find()
        ->where([
            'child_analyst' => $location,
            'line' => $line,
            'plan_date' => $today
        ])
        ->andWhere(['<>', 'plan_run', 'R'])
        ->orderBy('plan_run DESC')
        ->all();

        $plan_data_arr = [];
        foreach ($plan_data as $value) {
            $plan_data_arr[] = [
                'lot_no' => $value->lot_id,
                'part_no' => $value->child_all,
                'part_desc' => $value->child_desc_all,
                'qty' => $value->qty_all,
                'status' => $value->plan_stats == 'O' ? 'OPEN' : 'CLOSED',
            ];
        }
        /*if (count($plan_data_arr) == 0) {
            $plan_data_arr[]= [
                'part_no' => '-',
                'part_desc' => '-',
                'qty' => '0',
                'status' => '-',
            ];
        }*/

        return $plan_data_arr;
    }
}