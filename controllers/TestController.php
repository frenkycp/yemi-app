<?php
namespace app\controllers;

use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Url;

class TestController extends Controller
{
	public function actionSendEmail($value='')
	{
		//echo \Yii::getAlias('@webroot') . '/uploads/tp_part_list.xls';
		/*$message = \Yii::$app->mailer->compose();
		$message->setFrom('mainanhp001@gmail.com')
		->setTo('frenky.purnama@music.yamaha.com')
		->setSubject('Email sent from Yii2-Swiftmailer')
		->setTextBody('Teks yang tampil di body')
		->setHtmlBody('<b style="color: blue;">Contoh teks HTML</b>')
		->attach(\Yii::getAlias('@webroot') . '/uploads/tp_part_list.xls')
		->send();*/
		\Yii::$app->mailer->compose(['html' => '@app/mail/layouts/yesterday-summary'], [
			'content' => 'isinya'
		])
		->setFrom('mainanhp001@gmail.com')
		->setTo('frenky.purnama@music.yamaha.com')
		->setSubject('Advanced email from Yii2-SwiftMailer')
		->send();
	}

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