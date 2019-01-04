<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\GojekView02;
use app\models\GojekTbl;
use yii\helpers\ArrayHelper;

/**
 * 
 */
class GojekDriverAvgCompletionController extends Controller
{
	public function actionIndex()
	{
		$data = [];
		$categories = [];
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

		$tmp_driver_arr = GojekTbl::find()
		->where(['<>', 'TERMINAL', 'Z'])
		->orderBy('GOJEK_DESC')
		->all();

		$gojek_data_arr = GojekView02::find()
		->select([
			'GOJEK_ID',
			'GOJEK_DESC',
			'AVERAGE_ORDER_COMPLETION' => 'ROUND(AVG(AVERAGE_ORDER_COMPLETION),0)'
		])
		->where([
			'ISSUE_PERIOD' => $period
		])
		->groupBy('GOJEK_ID, GOJEK_DESC')
		->orderBy('GOJEK_DESC')
		->all();

		foreach ($tmp_driver_arr as $tmp_driver) {
			$categories[] = $tmp_driver->GOJEK_DESC;
			$tmp_avg = null;
			foreach ($gojek_data_arr as $gojek_data) {
				if ($tmp_driver->GOJEK_ID == $gojek_data->GOJEK_ID) {
					$tmp_avg = (int)$gojek_data->AVERAGE_ORDER_COMPLETION;
				}
			}
			$tmp_data[] = [
				'y' => $tmp_avg
			];
		}

		

		$data[] = [
			'name' => 'One Job Completion Time (AVG)',
			'data' => $tmp_data
		];

		return $this->render('index', [
			'data' => $data,
			'categories' => $categories,
			'year' => $year,
			'month' => $month,
		]);
	}
}