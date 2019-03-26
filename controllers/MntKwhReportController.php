<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\MachineKwhReport;

class MntKwhReportController extends Controller
{
	public function actionIndex()
	{
		$data = [];
		$machine_id = 'MNT00211';
		$posting_date = date('Y-m-d');
		$categories = [];

		if (\Yii::$app->request->get('posting_date') !== null) {
			$posting_date = \Yii::$app->request->get('posting_date');
		}

		if (\Yii::$app->request->get('machine_id') !== null) {
			$machine_id = \Yii::$app->request->get('machine_id');
		}

		$data_report = MachineKwhReport::find()
		->where([
			'posting_date' => $posting_date,
			'mesin_id' => $machine_id,
		])
		->all();

		$tmp_data = [];
		for ($i=1; $i <= 24; $i++) { 
			$kwh = null;
			foreach ($data_report as $key => $value) {
				if ($i == $value->jam_no) {
					$kwh = (int)$value->power_consumption;
				}
			}
			$categories[] = $i;
			$tmp_data[] = $kwh;
		}

		$data[] = [
			'name' => 'Working Hour',
			'data' => $tmp_data,
			'showInLegend' => false
		];

		return $this->render('index', [
			'data' => $data,
			'posting_date' => $posting_date,
			'machine_id' => $machine_id,
			'categories' => $categories
		]);
	}
}