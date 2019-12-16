<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\MachineMpPlanViewMaster02;
use app\models\PlanReceivingPeriod;

class AparWeeklyPreventiveController extends Controller
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

        $year_now = date('Y');
        $star_year = 2018;
    	for ($year = $star_year; $year <= ($year_now + 1); $year++) {
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
		->andWhere(['like', 'mesin_id', 'SHE'])
		->orderBy('period, week, master_plan_maintenance')
		->all();

		$target = 0;
		$actual = 0;
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
			$target += $masterplan_data->count_list;
			$actual += $masterplan_data->count_close;
		}

		foreach ($tmp_data as $key => $value) {
			$tmp_category = [];
			$presentase_open_arr = [];
			$presentase_close_arr = [];
			foreach ($tmp_data[$key] as $key2 => $value2) {
				if ($key2 != 'target' && $key2 != 'actual') {
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
						'url' => Url::to(['fire-equipment-preventive/index',
							'master_plan_maintenance' => $key2,
							'status' => 0
						])
					];
					$presentase_close_arr[] = [
						'y' => $presentase_close,
						'qty' => $value2['total_close'],
						'url' => Url::to(['fire-equipment-preventive/index',
							'master_plan_maintenance' => $key2,
							'status' => 1
						])
					];
				}
				
			}
			$data[$key] = [
				'category' => $tmp_category,
				'target' => $value['target'],
				'actual' => $value['actual'],
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
			'data' => $data,
			'target' => $target,
			'actual' => $actual,
		]);
	}
}