<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekTbl;
use app\models\GojekView02;

class GojekDriverUtilityController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$data = [];
		$categories = $this->getCategoriesArr();
		$driver_arr = $this->getDriverArr();

		$view_data_arr = GojekView02::find()
		->orderBy('ISSUE_DATE ASC')
		->all();

		
		foreach ($driver_arr as $driver) {
			$tmp_data = [];
			$tmp_data2 = [];
			foreach ($categories as $category) {
				$utility = 0;
				$average_order_completion = 0;
				$post_date = (strtotime("$category +3 hours") * 1000);
				foreach ($view_data_arr as $view_data) {
					
					if ($view_data->GOJEK_DESC == $driver && $view_data->ISSUE_DATE == $category) {
						$utility = $view_data->UTILITY;
						$average_order_completion = $view_data->AVERAGE_ORDER_COMPLETION;
					}
					
				}
				$tmp_data[] = [
					'x' => $post_date,
					'y' => (float)$utility
				];
				$tmp_data2[] = [
					'x' => $post_date,
					'y' => (float)$average_order_completion
				];
			}
			$data[] = [
				'name' => $driver,
				'data' => $tmp_data
			];
			$data2[] = [
				'name' => $driver,
				'data' => $tmp_data2
			];
		}

		return $this->render('index', [
			'data' => $data,
			'data2' => $data2,
			'categories' => $categories,
		]);
	}

	public function getCategoriesArr()
	{
		$data_arr = GojekView02::find()->select('DISTINCT(ISSUE_DATE)')->orderBy('ISSUE_DATE')->all();
		$return_arr = [];
		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value->ISSUE_DATE;
		}
		return $return_arr;
	}

	public function getDriverArr()
	{
		$driver_arr = GojekTbl::find()->select('GOJEK_ID, GOJEK_DESC')->groupBy('GOJEK_ID, GOJEK_DESC')->orderBy('GOJEK_DESC')->all();
		$return_arr = [];
		foreach ($driver_arr as $key => $value) {
			$return_arr[] = $value->GOJEK_DESC;
		}

		return $return_arr;
	}
}