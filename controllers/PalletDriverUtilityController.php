<?php
namespace app\controllers;

use yii\web\Controller;

//use app\models\User;
use app\models\PalletDriver;
use app\models\PalletUtilityView03;
use yii\helpers\ArrayHelper;

class PalletDriverUtilityController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$categories = $this->getCategoriesArr();
    	/*$driver_data_arr = User::find()
    	->select('username, name')
		->where([
			'role_id' => [19, 20]
		])
		->orderBy('name')
		->all();*/

		$driver_data_arr = PalletDriver::find()
		->where([
			'driver_type' => 1
		])
		->orderBy('driver_name')
		->all();

		$driver_dropdown_arr = ArrayHelper::map(PalletDriver::find()
			->where([
				'driver_type' => 1
			])
			->orderBy('driver_name')
			->all(), 'nik', 'driver_name');

		$utility_data_arr = PalletUtilityView03::find()
		->orderBy('order_date, nik')
		->all();

		if (\Yii::$app->request->get('driver_nik') !== null) {
			/*$driver_data_arr = User::find()
			->select('username, name')
			->where([
				'username' => \Yii::$app->request->get('driver_nik')
			])
			->orderBy('name')
			->all();*/
			$driver_data_arr = PalletDriver::find()
			->where([
				'nik' => \Yii::$app->request->get('driver_nik')
			])
			->orderBy('driver_name')
			->all();
		}

		$data = [];
		$data2 = [];
		foreach ($driver_data_arr as $key => $driver_data) {
			$tmp_data = [];
			$tmp_data2 = [];
			foreach ($categories as $key => $category) {
				$order_date = strtotime("$category +10 hours") * 1000;
				$utility = 0;
				$avg_time = 0;
				foreach ($utility_data_arr as $key => $utility_data) {
					if ($utility_data->nik == $driver_data->nik && $utility_data->order_date == $category) {
						$utility = round($utility_data->utilization);
						$avg_time = $utility_data->avg_time;
					}
				}
				$tmp_data[] = [
					'x' => $order_date,
					'y' => (float)$utility
				];
				$tmp_data2[] = [
					'x' => $order_date,
					'y' => (int)$avg_time
				];
			}
			
			$data[] = [
				'name' => $driver_data->driver_name,
				'data' => $tmp_data
			];
			$data2[] = [
				'name' => $driver_data->driver_name,
				'data' => $tmp_data2
			];
		}

		
        return $this->render('index', [
            'data' => $data,
            'data2' => $data2,
            'driver_dropdown_arr' => $driver_dropdown_arr,
        ]);
    }

    public function getCategoriesArr()
	{
		//$data_arr = GojekView02::find()->select('DISTINCT(ISSUE_DATE)')->orderBy('ISSUE_DATE')->all();
		$data_arr = ArrayHelper::getColumn(
			PalletUtilityView03::find()->select('DISTINCT(order_date)')
			->where(['>', 'order_date', date('Y-m-d', strtotime("-1 month"))])
			->orderBy('order_date')
			->asArray()
			->all(),
			'order_date'
		);
		$return_arr = [];
		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value;
		}
		return $return_arr;
	}
}