<?php
namespace app\controllers;

use yii\web\Controller;

class DisplayToggleOneController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		return $this->render('index');
	}

	public function actionVisitorClinic()
	{
		$this->layout = 'clean';
		return $this->render('visitor-clinic');
	}
}