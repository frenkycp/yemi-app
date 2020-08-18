<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\MachineIotCurrent;
use app\models\MachineIotCurrentMnt;

class MntMachineIotController extends Controller
{
	public function actionCurrentStatus()
	{
		$tmp_data = MachineIotCurrent::find()->where(['is_iot' => 'Y'])->orderBy('mesin_description')->asArray()->all();
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $tmp_data;
	}

	public function actionMachinePerformance()
	{
		$this->layout = 'clean';
		$data = MachineIotCurrentMnt::find()->where('status_warna_second IS NOT NULL')->orderBy('mesin_description')->all();
		return $this->render('machine-performance', [
			'data' => $data
		]);
	}
}