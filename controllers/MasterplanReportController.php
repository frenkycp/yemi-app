<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\MachineMpPlanViewMaster02;
use app\models\PlanReceivingPeriod;

class MasterplanReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	function actionIndex()
	{
		$tmp_data = [];
		$data = [];
		$year_arr = [];
		$month_arr = [];

		for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = MachineMpPlanViewMaster02::find()->select('MIN(year) as min_year')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
    	for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }
        

		$period = date('Ym');

		$model = new PlanReceivingPeriod();
		$model->year = date('Y');
		$model->month = date('m');
		if ($model->load($_POST))
		{
			$period = $model->year . $model->month;
		}

		$masterplan_data_arr = MachineMpPlanViewMaster02::find()
		->where([
			'period' => $period
		])
		->orderBy('period, week, master_plan_maintenance')
		->all();

		foreach ($masterplan_data_arr as $masterplan_data) {
			if (!isset($tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_open'])) {
				$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_open'] = 0;
			}
			if (!isset($tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_close'])) {
				$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_close'] = 0;
			}
			if (!isset($tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_plan'])) {
				$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_plan'] = 0;
			}

			$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_open'] += $masterplan_data->count_open;
			$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_close'] += $masterplan_data->count_close;
			$tmp_data[$masterplan_data->week][$masterplan_data->master_plan_maintenance]['total_plan'] += $masterplan_data->count_list;
		}

		foreach ($tmp_data as $key => $value) {
			$tmp_category = [];
			$presentase_open_arr = [];
			$presentase_close_arr = [];
			foreach ($tmp_data[$key] as $key2 => $value2) {
				$tmp_category[] = $key2;
				$presentase_open = 0;
				$presentase_close = 0;
				if ($value2['total_plan'] > 0) {
					$presentase_open = round((($value2['total_open'] / $value2['total_plan']) * 100), 2);
					$presentase_close = round((($value2['total_close'] / $value2['total_plan']) * 100), 2);
				}
				$presentase_open_arr[] = [
					'y' => $presentase_open,
					'qty' => $value2['total_open'],
					'url' => Url::to(['mnt-preventive-data/index',
						'master_plan_maintenance' => $key2,
						'status' => 0
					])
				];
				$presentase_close_arr[] = [
					'y' => $presentase_close,
					'qty' => $value2['total_close'],
					'url' => Url::to(['mnt-preventive-data/index',
						'master_plan_maintenance' => $key2,
						'status' => 1
					])
				];
			}
			$data[$key] = [
				'category' => $tmp_category,
				'data' => [
					[
						'name' => 'OPEN',
						'data' => $presentase_open_arr,
						'color' => 'rgba(200, 200, 200, 0.4)',
						//'showInLegend' => false,
    					'dataLabels' => [
    						'enabled' => true,
    						'format' => '{point.percentage:.0f}%<br/>({point.qty})',
    					]
					],
					[
						'name' => 'CLOSE',
						'data' => $presentase_close_arr,
						'color' => 'rgba(72,61,139,0.6)',
						//'showInLegend' => false,
						'dataLabels' => [
                            'enabled' => true,
                            'format' => '{point.percentage:.0f}%<br/>({point.qty})',
                        ]
					]
				]
			];
		}

		return $this->render('index', [
			'model' => $model,
			'year_arr' => $year_arr,
			'month_arr' => $month_arr,
			'data' => $data
		]);
	}
}