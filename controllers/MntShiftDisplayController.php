<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\MntShiftCode;
use app\models\MntShiftView;

class MntShiftDisplayController extends Controller
{
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->layout = 'clean';
		$data = [];
		$today = date('Y-m-d');
		$current_time = date('Y-m-d H:i:s');
		//$current_time = date('Y-m-d 02:00:00');

		if ($current_time < date('Y-m-d 07:00:00')) {
			$today = date('Y-m-d', strtotime('-1 day'));
		}

		$shift_view = MntShiftView::find()
		->where([
			'shift_date' => $today
		])
		->orderBy('shift_code, name')
		->all();

		foreach ($shift_view as $key => $value) {
			$data[$value->shift_code][] = [
				'nik' => $value->nik,
				'name' => $value->name,
				'phone' => $value->phone,
			];
		}

		return $this->render('index', [
			'data' => $data,
			'today' => $today
		]);
	}
}