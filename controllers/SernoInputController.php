<?php

namespace app\controllers;

use app\models\search\SernoInputSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "SernoInputController".
*/
class SernoInputController extends \app\controllers\base\SernoInputController
{
	/**
	* Lists all SernoInput models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new SernoInputSearch;
	    if (\Yii::$app->request->get('status') !== null) {
	    	$searchModel->status = \Yii::$app->request->get('status');
	    }
	    $searchModel->proddate = date('Y-m-d');
	    if (\Yii::$app->request->get('proddate') !== null) {
	    	$searchModel->proddate = \Yii::$app->request->get('proddate');
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
