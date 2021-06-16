<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\MachineIotCurrent;
use app\models\MachineIotCurrentMnt;

class MntMachineIotController extends Controller
{
	public function actionCurrentStatus()
	{
		date_default_timezone_set('Asia/Jakarta');
		$tmp_data = MachineIotCurrentMnt::find()->orderBy('mesin_description')->asArray()->all();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$data = [
			'last_update' => date('Y-m-d H:i:s'),
			'data' => $tmp_data
		];
		return $data;
	}

	public function actionMachinePerformance()
	{
		$this->layout = 'clean';
		$group_arr = [
			[
				'MNT00497' => 'INJ-50',
				'MNT00428' => 'INJ-100',
				'MNT00429' => 'INJ-125',
				'MNT00430' => 'INJ-180',
				'MNT00431' => 'INJ-180',
				'MNT00494' => 'INJ-350',
				'MNT00432' => 'INJ-850',
				'MNT00433' => 'INJ-1600'
			],
			[
				'MNT00149' => 'REAKTOR 1',
				'MNT00150' => 'REAKTOR 2',
				'MNT00151' => 'REAKTOR 3',
				'MNT00693' => 'REAKTOR 4'
			],
			[
				'MNT00076' => 'NCB-1 SCM',
				'MNT00077' => 'NCB-2 SCM',
				'MNT00078' => 'NCB-3 SCM',
				'MNT00079' => 'NCB-4 SCM',
				'MNT00081' => 'NCB-5 SCM',
				'MNT01616' => 'NCB-6',
				'MNT00098' => 'HVC-1',
				'MNT00099' => 'HVC-2',
				'MNT00100' => 'HVC-3',
				'MNT00091' => 'S-LAM'
			],
			[
				'MNT00083' => 'DET-1',
				'MNT00084' => 'DET-2',
				'MNT00085' => 'DET-3',
				'MNT00052' => 'NCR-1',
				'MNT00053' => 'NCR-2',
				'MNT00054' => 'NCR-3',
				'MNT00055' => 'NCR-4',
				'MNT00056' => 'NCR-5',
				'MNT00057' => 'NCR-6',
				'MNT00058' => 'NCR-7',
				'MNT01615' => 'NCR-8'
			],
			[
				'MNT00021' => 'RSAW-1',
				'MNT00022' => 'RSAW-2',
				'MNT00023' => 'RSAW-3',
				'MNT00017' => 'PSAW-2'
			],
			[
				'MNT00252' => 'QACBR-1',
				'MNT00253' => 'QACBR-2',
				'MNT00254' => 'QACBR-3'
			],
		];
		$data = MachineIotCurrentMnt::find()->where('status_warna_second IS NOT NULL')->orderBy('mesin_description')->all();
		return $this->render('machine-performance', [
			'data' => $data,
			'group_arr' => $group_arr
		]);
	}
}