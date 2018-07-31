<?php

namespace app\controllers;

use Yii;
use app\models\PlanReceiving;
use app\models\search\PlanReceivingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PlanReceivingPeriod;
use app\models\Vehicle;

class PlanReceivingVisualController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$year_arr = [];
		$month_arr = [];
		$min_year = PlanReceiving::find()->select('MIN(CAST(LEFT(month_periode,4) as UNSIGNED)) as `min_year`')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

		$model = new PlanReceivingPeriod();
		$model->month = date('m');
		$model->year = date('Y');
		if ($model->load($_POST))
		{

		}

		$plan_receiving_arr = PlanReceiving::find()
		->select([
			'week_no' => 'WEEK(receiving_date, 4)',
			'receiving_date' => 'receiving_date',
			'total_container' => 'SUM(CASE WHEN vehicle=\'Container\' THEN qty ELSE 0 END)',
			'total_truck' => 'SUM(CASE WHEN vehicle=\'Truck\' THEN qty ELSE 0 END)',
			'total_wb' => 'SUM(CASE WHEN vehicle=\'WB\' THEN qty ELSE 0 END)'
		])
		->where([
			'month_periode' => $model->year . $model->month
		])
		->groupBy('week_no, receiving_date')
		->orderBy('week_no, receiving_date')
		->all();

		$tmp_data = [];
		foreach ($plan_receiving_arr as $plan_receiving) {
			$receiving_date = $plan_receiving->receiving_date;
			$week_no = $plan_receiving->week_no;
			$tmp_data[$week_no][$receiving_date]['total_container'] = $plan_receiving->total_container;
			$tmp_data[$week_no][$receiving_date]['total_truck'] = $plan_receiving->total_truck;
			$tmp_data[$week_no][$receiving_date]['total_wb'] = $plan_receiving->total_wb;
		}

		$data = [];
		$week_today = date('W');
		$week_no_arr = [];
		$week_found = false;
		foreach ($tmp_data as $week_no => $plan_receiving) {
			$week_no_arr[] = $week_no;
			if ($week_no == $week_today) {
				$week_found = true;
			}
			$tmp_category = [];
			$total_container_arr = [];
			$total_truck_arr = [];
			$total_wb_arr = [];
			foreach ($plan_receiving as $receiving_date => $value) {
				$tmp_category[] = $receiving_date;
				$total_container_arr[] = [
					'y' => (int)$value['total_container'],
					'remark' => $this->getDetailVehicle($receiving_date, 'Container')
				];
				$total_truck_arr[] = [
					'y' => (int)$value['total_truck'],
					'remark' => $this->getDetailVehicle($receiving_date, 'Truck')
				];
				$total_wb_arr[] = [
					'y' => (int)$value['total_wb'],
					'remark' => $this->getDetailVehicle($receiving_date, 'WB')
				];
			}
			$data[$week_no] = [
				'category' => $tmp_category,
				'data' => [
					[
						'name' => 'Container',
						'data' => $total_container_arr
					],
					[
						'name' => 'Truck',
						'data' => $total_truck_arr
					],
					[
						'name' => 'WB',
						'data' => $total_wb_arr
					]
				]
			];
		}

		if (!$week_found) {
			$week_today = $week_no_arr[0];
		}

		/*echo '<pre>';
		print_r($data);
		echo '</pre>';*/
		
		return $this->render('index',[
			'model' => $model,
			'data' => $data,
			'week_today' => $week_today,
			'year_arr' => $year_arr,
			'month_arr' => $month_arr
		]);
	}

	public function getVehicleArr()
	{
		$vehicle_arr = [];
		$tmp_data_arr = Vehicle::find()->where(['flag' => 1])->all();
		foreach ($tmp_data_arr as $tmp_data) {
			$vehicle_arr[] = $tmp_data->name;
		}

		return $vehicle_arr;
	}

	public function getDetailVehicle($receiving_date, $vehicle)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr class="info">
            <th class="text-center">Receiving Date</th>
            <th class="text-center">Vendor Name</th>
            <th class="text-center">Vehicle</th>
            <th class="text-center">Container No.</th>
            <th class="text-center">Qty</th>
            <th class="text-center">Item Type</th>
        </tr>';

        $plan_receiving_arr = PlanReceiving::find()
        ->where([
        	'receiving_date' => $receiving_date,
        	'vehicle' => $vehicle
        ])
        ->all();

        foreach ($plan_receiving_arr as $plan_receiving) {
        	$data .= '
                <tr>
                    <td class="text-center">' . $plan_receiving->receiving_date .'</td>
                    <td class="text-center">' . $plan_receiving->vendor_name .'</td>
                    <td class="text-center">' . $plan_receiving->vehicle .'</td>
                    <td class="text-center">' . $plan_receiving->container_no .'</td>
                    <td class="text-center">' . $plan_receiving->qty .'</td>
                    <td class="text-center">' . $plan_receiving->item_type .'</td>
                </tr>
            ';
        }

        $data .= '</table>';

        return $data;
	}
}