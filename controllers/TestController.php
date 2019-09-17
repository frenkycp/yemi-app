<?php
namespace app\controllers;

use yii\web\Controller;

class TestController extends Controller
{
	public function actionIndex()
	{
		$machine_id = 'MNT00211';
		$this->layout = 'clean';

		if (\Yii::$app->request->get('machine_id') !== null) {
			$machine_id = \Yii::$app->request->get('machine_id');
		}

		return $this->render('index', [
			'machine_id' => $machine_id
		]);
	}

	public function actionFullCalendar()
	{
		return $this->render('full-calendar');
	}
}