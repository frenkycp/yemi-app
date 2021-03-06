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

		$model = new \yii\base\DynamicModel([
            'post_date'
        ]);
        $model->addRule(['post_date'], 'required');
        $model->post_date = date('Y-m-d');

		if ($current_time < date('Y-m-d 07:00:00')) {
			$today = date('Y-m-d', strtotime('-1 day'));
			$model->post_date = date('Y-m-d', strtotime(' -1 day'));
		}

		if ($model->load($_GET)) {

		}

		$shift_view = MntShiftView::find()
		->where([
			'shift_date' => $model->post_date
		])
		->orderBy('shift_code, name')
		->all();

		foreach ($shift_view as $key => $value) {
			$data[$value->shift_code][] = [
				'nik' => $value->nik,
				'name' => $value->name,
				'speed_dial' => $value->speed_dial,
				'phone' => $value->phone,
			];
		}

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
			//'today' => $today
		]);
	}
}