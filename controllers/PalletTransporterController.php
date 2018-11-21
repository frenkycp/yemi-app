<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoSlip;
use app\models\SernoSlipLog;
use app\models\Action;

class PalletTransporterController extends Controller
{

	public function behaviors()
    {
        //NodeLogger::sendLog(Action::getAccess($this->id));
        //apply role_action table for privilege (doesn't apply to super admin)
        return Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		
		if (\Yii::$app->user->identity->role->name == 'Pallet Driver 1') {
			$fa = 1;
		} else {
			$fa = 2;
		}
		$line_data = SernoSlip::find()->where([
			'fa' => $fa
		])
		->andWhere(['<>', 'user', 'MIS'])
		->orderBy('status DESC, user ASC')
		->asArray()
		->all();
		return $this->render('index',[
			'line_data' => $line_data,
			'fa' => $fa
		]);
	}

	public function actionProcess($line, $current_status)
	{
		date_default_timezone_set('Asia/Jakarta');
		$line_data = SernoSlip::find()->where([
			'user' => $line
		])->one();

		if ($line_data->status == 0) {
			\Yii::$app->getSession()->setFlash('warning', 'Order from line ' . $line . ' had been picked up...');
			return $this->redirect('index');
		}

		$line_data->status = 0;
		if ($line_data->save()) {
			$log = SernoSlipLog::find()->where([
				'line' => $line
			])
			->andWhere('end IS NULL')
			->one();
			$log->end = date('H:i:s');
			$log->nik = \Yii::$app->user->identity->username;
			if (!$log->save()) {
				print_r($log->errors);
			}
			\Yii::$app->getSession()->setFlash('success', 'You picked up order from line ' . $line . '...');
		}

		return $this->redirect('index');
	}
}