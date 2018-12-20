<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekTbl;
use app\models\GojekView02;
use yii\helpers\ArrayHelper;

class GoPickingDriverUtilityController extends Controller
{
	/**/public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = [];
		$categories = $this->getCategoriesArr();
		$driver_arr = GojekTbl::find()
		->select('GOJEK_ID, GOJEK_DESC')
		->where([
			'TERMINAL' => 'Z'
		])
		->groupBy('GOJEK_ID, GOJEK_DESC')
		->orderBy('GOJEK_DESC')->all();

		$view_data_arr = GojekView02::find()
		->orderBy('ISSUE_DATE ASC')
		->all();

		if (\Yii::$app->request->get('driver_nik') !== null) {
			$driver_arr = GojekTbl::find()
			->select('GOJEK_ID, GOJEK_DESC')
			->where([
				'GOJEK_ID' => \Yii::$app->request->get('driver_nik')
			])
			->groupBy('GOJEK_ID, GOJEK_DESC')
			->orderBy('GOJEK_DESC')->all();
		}
		
		foreach ($driver_arr as $driver) {
			$tmp_data = [];
			$tmp_data2 = [];
			foreach ($categories as $category) {
				$utility = 0;
				$average_order_completion = 0;
				$tmp_category = date('Y-m-d H:i:s', strtotime("$category 00:00:00"));
				$post_date = (strtotime("$tmp_category +10 hours") * 1000);
				foreach ($view_data_arr as $view_data) {
					
					if ($view_data->GOJEK_ID == $driver->GOJEK_ID && $view_data->ISSUE_DATE == $category) {
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
				'name' => $driver->GOJEK_DESC,
				'data' => $tmp_data
			];
			$data2[] = [
				'name' => $driver->GOJEK_DESC,
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
		//$data_arr = GojekView02::find()->select('DISTINCT(ISSUE_DATE)')->orderBy('ISSUE_DATE')->all();
		$data_arr = ArrayHelper::getColumn(
			GojekView02::find()->select('DISTINCT(ISSUE_DATE)')
			->where(['>', 'ISSUE_DATE', date('Y-m-d', strtotime("-1 month"))])
			->orderBy('ISSUE_DATE')
			->asArray()
			->all(),
			'ISSUE_DATE'
		);
		$return_arr = [];
		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value;
		}
		return $return_arr;
	}
}