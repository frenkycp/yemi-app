<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\MachineIotCurrent;

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
		$data = MachineIotCurrent::find()->where(['is_iot' => 'Y'])->orderBy('mesin_description')->all();
		return $this->render('machine-performance', [
			'data' => $data
		]);
	}
}