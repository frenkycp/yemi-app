<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\MesinCheckNg;
use yii\helpers\Url;

class MntProgressController extends Controller
{
	public function actionIndex()
	{
		$current_month = date('Y-m');
		$tmp_data = MesinCheckNg::find()
		->where(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $current_month])
		->andWhere(['repair_status' => 'O'])
		->orderBy('mesin_nama ASC')->all();
		$data_categories = [];
		$data_date = [];
		$title = date('F Y');
		$subtitle = '';
		$value_suffix = ' ' . date('F Y');

		foreach ($tmp_data as $value) {
			$data_categories[] = $value->mesin_nama;
			$start_date = date('j', strtotime($value->mesin_last_update));
			$end_date = date('j');
			if ($value->repair_aktual != null) {
				$end_date = date('j', strtotime($value->repair_aktual));
			}

			$status = $value->repair_status == 'C' ? 'CLOSED' : 'OPEN';

			if ($value->repair_status == 'O') {
				$color = 'rgba(255, 0, 0, 0.3)';
			}else {
				$color = 'rgba(0, 255, 0, 0.3)';
			}

			$repair_plan = $value->repair_plan == null ? '-' : date('d M Y', strtotime($value->repair_plan));
			
			$remark = '
			<div class="row">
				<div class="col-md-3"><b>Machine Name</b></div>
				<div class="col-md-9">: ' . $value->mesin_nama . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Status</b></div>
				<div class="col-md-9">: ' . $status . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Last Update</b></div>
				<div class="col-md-9">: ' . date('d M Y', strtotime($value->mesin_last_update)) . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Repair Plan</b></div>
				<div class="col-md-9">: ' . $repair_plan . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>NG Remark</b></div>
				<div class="col-md-9">: ' . $value->mesin_catatan . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Repair Note</b></div>
				<div class="col-md-9">: ' . $value->repair_note . '</div>
			</div>
			';
			
			$data_date[] = [
				'low' => (int)$start_date,
				'high' => (int)$end_date,
				'color' => $color,
				'url' => Url::to(['/mesin-check-ng/index', 'ticket_no' => $value->urutan]),
				'remark' => $remark
			];
		}
		return $this->render('index', [
			'data_categories' => $data_categories,
			'data_date' => $data_date,
			'title' => $title,
			'subtitle' => $subtitle,
			'value_suffix' => $value_suffix
		]);
	}
}