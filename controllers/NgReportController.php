<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\MntCorrectiveView;

class NgReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	function actionIndex()
	{
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}
		$period = $year . $month;

		$corrective_data_arr = MntCorrectiveView::find()
		->where([
			'period' => $period
		])
		->orderBy('period, week_no, issued_date')
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($corrective_data_arr as $key => $corrective_data) {
			$week_no = $corrective_data['week_no'];
			$issued_date = $corrective_data['issued_date'];
			$issued_date2 = (strtotime($issued_date . " +7 hours") * 1000);
			$total_open = $corrective_data['total_open'];
			$total_close = $corrective_data['total_close'];
			$tmp_data[$week_no]['open'][] = [
				'x' => $issued_date2,
				'y' => $total_open == 0 ? null : (int)$total_open,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'O', 'mesin_last_update' => $issued_date]),
                'qty' => $total_open,
			];
			$tmp_data[$week_no]['close'][] = [
				'x' => $issued_date2,
				'y' => (int)$total_close,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'C', 'mesin_last_update' => $issued_date]),
                'qty' => $total_close,
			];
		}

		$data = [];
		foreach ($tmp_data as $key => $value) {
			$data[$key] = [
				[
					'name' => 'OPEN',
					'data' => $value['open'],
					'color' => 'white',
				],
				[
					'name' => 'CLOSE',
					'data' => $value['close'],
					'color' => 'rgba(0, 200, 0, 0.7)',
				]
			];
		}

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}
}