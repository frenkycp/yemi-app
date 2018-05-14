<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "MesinCheckNgController".
*/
class MesinCheckNgController extends \app\controllers\base\MesinCheckNgController
{
	public function actionIndex()
	{
	    $searchModel  = new MesinCheckNgSearch;
	    if (\Yii::$app->request->get('mesin_last_update') !== null) {
	    	$searchModel->mesin_last_update = \Yii::$app->request->get('mesin_last_update');
	    }
	    if (\Yii::$app->request->get('repair_status') !== null) {
	    	$searchModel->repair_status = \Yii::$app->request->get('repair_status');
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

	public function actionNgProgress()
	{
		return $this->render('ng-progress', []);
	}
}
