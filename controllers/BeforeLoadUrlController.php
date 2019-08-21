<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\Visitor;
use app\models\KlinikInput;

class BeforeLoadUrlController extends Controller
{
	public function actionVisitorConfirm($url)
	{
		$tmp_visitor = Visitor::updateAll(['emp_dept' => 'PURCHASING'], ['LOWER(emp_dept)' => 'procurement']);

		return $this->redirect($url);
	}

	public function actionClinicConfirm($url)
	{
		$tmp_visitor = KlinikInput::updateAll(['dept' => 'PURCHASING'], ['LOWER(dept)' => 'procurement']);

		return $this->redirect($url);
	}
}