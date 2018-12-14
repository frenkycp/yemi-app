<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

class MntWeeklyPreventiveDataController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}