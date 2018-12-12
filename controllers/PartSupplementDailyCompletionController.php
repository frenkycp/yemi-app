<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\SupplementDailyProgressView;

class PartSupplementDailyCompletionController extends Controller
{
	public function actionIndex()
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

		$supplement_data_arr = SupplementDailyProgressView::find()
		->where([
			'period' => $period
		])
		->orderBy('date_spt ASC')
		->asArray()->all();

		foreach ($supplement_data_arr as $key => $supplement_data) {
			$proddate = (strtotime($supplement_data['date_spt'] . " +7 hours") * 1000);
			$tmp_data_request[] = [
				'x' => $proddate,
				'y' => $supplement_data['request_qty'] == 0 ? null : (int)$supplement_data['request_qty'],
				'qty' => (int)$supplement_data['request_qty']
			];
			$tmp_data_pc_approved[] = [
				'x' => $proddate,
				'y' => $supplement_data['pc_approved_qty'] == 0 ? null : (int)$supplement_data['pc_approved_qty'],
				'qty' => (int)$supplement_data['pc_approved_qty'],
			];
			$tmp_data_pc_rejected[] = [
				'x' => $proddate,
				'y' => $supplement_data['pc_rejected_qty'] == 0 ? null : (int)$supplement_data['pc_rejected_qty'],
				'qty' => (int)$supplement_data['pc_rejected_qty'],
			];
			$tmp_data_reject_history[] = [
				'x' => $proddate,
				'y' => $supplement_data['reject_history_qty'] == 0 ? null : (int)$supplement_data['reject_history_qty'],
				'qty' => (int)$supplement_data['reject_history_qty'],
			];
			$tmp_data_wh_approved[] = [
				'x' => $proddate,
				'y' => $supplement_data['wh_approved_qty'] == 0 ? null : (int)$supplement_data['wh_approved_qty'],
				'qty' => (int)$supplement_data['wh_approved_qty'],
			];
			$tmp_data_outstanding[] = [
				'x' => $proddate,
				'y' => $supplement_data['outstanding_qty'] == 0 ? null : (int)$supplement_data['outstanding_qty'],
				'qty' => (int)$supplement_data['outstanding_qty'],
			];
			$tmp_data_wh_rejected[] = [
				'x' => $proddate,
				'y' => $supplement_data['wh_rejected_qty'] == 0 ? null : (int)$supplement_data['wh_rejected_qty'],
				'qty' => (int)$supplement_data['wh_rejected_qty'],
			];
			$tmp_data_pulled_up[] = [
				'x' => $proddate,
				'y' => $supplement_data['pulled_up_qty'] == 0 ? null : (int)$supplement_data['pulled_up_qty'],
				'qty' => (int)$supplement_data['pulled_up_qty'],
			];
		}

		$data = [
			[
				'name' => 'Order',
				'data' => $tmp_data_request
			],
			[
				'name' => 'PC Approved',
				'data' => $tmp_data_pc_approved
			],
			[
				'name' => 'PC Rejected',
				'data' => $tmp_data_pc_rejected
			],
			[
				'name' => 'Reject History',
				'data' => $tmp_data_reject_history
			],
			[
				'name' => 'WH Approved',
				'data' => $tmp_data_wh_approved
			],
			[
				'name' => 'Outstanding',
				'data' => $tmp_data_outstanding
			],
			[
				'name' => 'WH Rejected',
				'data' => $tmp_data_wh_rejected
			],
			[
				'name' => 'Pulled Up',
				'data' => $tmp_data_pulled_up
			],
		];

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}
}