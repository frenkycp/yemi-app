<?php
namespace app\controllers;

use yii\web\Controller;
use yii\httpclient\Client;

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

	public function actionWebService($value='')
	{
    	$client = new \mongosoft\soapclient\Client([
		    'url' => 'http://172.17.144.211/WebService01.asmx?WSDL',
		]);
		$client->IPQA_Patrol_Rank_S(['id' => 642]);
	}
}