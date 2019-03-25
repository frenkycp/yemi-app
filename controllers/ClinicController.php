<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\models\KlinikInput;
use app\models\KlinikHandle;

class ClinicController extends controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		$available_beds = 3;
		$doctor_status = 2;
		$nurse_status = 1;

		$data = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->orderBy('pk DESC')
		->limit(15)
		->all();

		$today_visitor = KlinikInput::find()
		->where([
			'date(pk)' => date('Y-m-d')
		])
		->count();

		$monthly_visitor = KlinikInput::find()
		->where([
			'extract(year_month FROM pk)' => date('Ym')
		])
		->count();

		$bed_used = KlinikInput::find()
		->where(['>', 'keluar', date('H:i:s')])
		->andWhere([
			'date(pk)' => date('Y-m-d')
		])
		->count();

		$available_beds -= $bed_used;
		if ($available_beds < 0) {
			$available_beds = 0;
		}

		if ($doctor_status == 1) {
			$doctor_data = [
				'status' => 'AVAILABLE',
				'bg_color' => 'bg-green'
			];
		} else {
			$doctor_data = [
				'status' => 'NOT AVAILABLE',
				'bg_color' => 'bg-orange'
			];
		}

		if ($nurse_status == 1) {
			$nurse_data = [
				'status' => 'AVAILABLE',
				'bg_color' => 'bg-green'
			];
		} else {
			$nurse_data = [
				'status' => 'NOT AVAILABLE',
				'bg_color' => 'bg-orange'
			];
		}

		return $this->render('index', [
			'today_visitor' => $today_visitor,
			'monthly_visitor' => $monthly_visitor,
			'available_beds' => $available_beds,
			'doctor_data' => $doctor_data,
			'nurse_data' => $nurse_data,
			'data' => $data,
		]);
	}
}