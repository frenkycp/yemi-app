<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoSlip;
use app\models\SernoSlipLog;
use app\models\Action;
use app\models\PalletDriver;
use app\models\Karyawan;

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
		$nik = \Yii::$app->user->identity->username;

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
			$log->nik = $nik;
			if (!$log->save()) {
				print_r($log->errors);
			}

			$pallet_driver = PalletDriver::find()
			->where([
				'nik' => $nik
			])
			->one();

			if ($pallet_driver == null) {
				$pallet_driver = new PalletDriver();
				$karyawan = Karyawan::find()
				->where([
					'NIK' => $nik
				])
				->one();
				$pallet_driver->nik = $nik;
				$pallet_driver->driver_name = $karyawan->NAMA_KARYAWAN;
				$pallet_driver->order_from = $line;
				$pallet_driver->todays_point = 0;
			}

			$today = new \DateTime(date('Y-m-d'));
			$last_update = new \DateTime(date('Y-m-d', strtotime($pallet_driver->last_update)));

			if (!($today == $last_update)) {
				$pallet_driver->todays_point = 0;
			}

			$pallet_driver->driver_status = 1;
			$pallet_driver->last_update = date('Y-m-d H:i:s');
			if (!$pallet_driver->save()) {
				print_r($pallet_driver->errors);
			}

			\Yii::$app->getSession()->setFlash('success', 'You picked up order from line ' . $line . '...');
		}

		return $this->redirect('index');
	}

	public function actionProcessArrival($line, $nik)
	{
		date_default_timezone_set('Asia/Jakarta');
		
		$log = SernoSlipLog::find()->where([
			'line' => $line, 
			'nik' => $nik
		])
		->andWhere('arrival_time IS NULL')
		->one();

		$log->arrival_time = date('H:i:s');
		if (!$log->save()) {
			print_r($log->errors);
		} else {
			$pallet_driver = PalletDriver::find()
			->where([
				'nik' => $nik
			])
			->one();
			
			$pallet_driver->todays_point++;
			$pallet_driver->last_update = date('Y-m-d H:i:s');
			$pallet_driver->driver_status = 2;
			if (!$pallet_driver->save()) {
				print_r($pallet_driver->errors);
			}
		}
		\Yii::$app->getSession()->setFlash('info', 'You have finished order from line ' . $line . '...');

		return $this->redirect('index');
	}
}