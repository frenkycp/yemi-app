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
	    if (\Yii::$app->request->get('child_analyst') !== null) {
	    	$searchModel->child_analyst = \Yii::$app->request->get('child_analyst');
	    }
	    if (\Yii::$app->request->get('line') !== null) {
	    	$searchModel->line = \Yii::$app->request->get('line');
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
