<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\MachineIotCurrentEff;
use app\models\MachineIotCurrentEffLog;

class MachineIotCurrentEffController extends Controller
{
	public function actionIndex()
	{
		$machine_iot = MachineIotCurrentEff::find()->orderBy('pct')->all();

		$tmp_data = [];
		foreach ($machine_iot as $key => $value) {
			$tmp_data[] = [
				'name' => $value['mesin_description'],
				'y' => $value['pct'],
				'drilldown' => $value['mesin_id']
			];
		}

		$series = [
			[
				'name' => 'Current Utility',
				'data' => $tmp_data
			]
		];

		return $this->render('index', [
			'series' => $series,
		]);
	}
}