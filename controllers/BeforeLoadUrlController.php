<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\Visitor;
use app\models\KlinikInput;
use app\models\DeptCorrection;

class BeforeLoadUrlController extends Controller
{
	public function actionVisitorConfirm($url)
	{
		$correction_data = DeptCorrection::find()
		->where([
			'flag' => 1
		])
		->all();

		foreach ($correction_data as $key => $value) {
			Visitor::updateAll(['emp_dept' => $value->after], ['LOWER(emp_dept)' => $value->before]);
		}
		
		return $this->redirect($url);
	}

	public function actionClinicConfirm($url)
	{
		$correction_data = DeptCorrection::find()
		->where([
			'flag' => 1
		])
		->all();

		foreach ($correction_data as $key => $value) {
			KlinikInput::updateAll(['dept' => $value->after], ['LOWER(dept)' => $value->before]);
		}

		return $this->redirect($url);
	}
}