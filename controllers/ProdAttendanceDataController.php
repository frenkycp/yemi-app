<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\ProdAttendanceDataSearch;

class ProdAttendanceDataController extends \app\controllers\base\ProdAttendanceDataController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
	    $searchModel  = new ProdAttendanceDataSearch;
	    $searchModel ->current_status = 'I';
	    $searchModel->posting_shift = date('Y-m-d');
	    if (\Yii::$app->request->get('posting_shift') !== null) {
	    	$searchModel->posting_shift = \Yii::$app->request->get('posting_shift');
	    }
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}
}
