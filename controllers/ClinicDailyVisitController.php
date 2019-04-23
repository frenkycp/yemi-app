<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\ClinicDailyVisit;

class ClinicDailyVisitController extends Controller
{
	public function actionIndex()
	{
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

		$daily_visit = ClinicDailyVisit::find()
		->where([
			'period' => $period
		])
		->all();

		$tmp_data = [];
		foreach ($daily_visit as $key => $value) {
			$proddate = (strtotime($value->input_date . " +7 hours") * 1000);
			$tmp_data[] = [
				'x' => $proddate,
				'y' => (int)$value->total_visitor,
				'url' => Url::to(['clinic-data/index', 'input_date' => $value->input_date]),
			];
		}

		$data[] = [
			'name' => 'Total Visitor',
			'data' => $tmp_data,
			'showInLegend' => false
		];

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}
}