<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\SernoRfid;

/**
 * 
 */
class RfidInputController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		$model = new sernoRfid();

		if($model->load(\Yii::$app->request->post())){
			try {
				$rfid_no = $model->rfid;
			    $model->save();
			    $model->rfid = null;
			    \Yii::$app->session->setFlash('success', "RFID Number : $rfid_no has been registered.");
			} catch (Exception $ex) {
				\Yii::$app->session->setFlash('danger', "Error : $ex");
			}
		}

		return $this->render('index', [
			'model' => $model
		]);
	}
}