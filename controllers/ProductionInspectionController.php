<?php

namespace app\controllers;

use app\models\search\ProductionInspectionSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "ProductionInspectionController".
*/
class ProductionInspectionController extends \app\controllers\base\ProductionInspectionController
{
	public function actionIndex()
{
    $searchModel  = new ProductionInspectionSearch;
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
