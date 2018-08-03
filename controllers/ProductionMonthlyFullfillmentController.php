<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\ProductionMonthlyFullfillmentSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\SernoOutput;

class ProductionMonthlyFullfillmentController extends Controller
{
    public function actionIndex()
    {

    	$searchModel  = new ProductionMonthlyFullfillmentSearch;
	    $searchModel->id = date('Ym');

	    if(\Yii::$app->request->get('id') !== null){
	    	$searchModel->id = \Yii::$app->request->get('id');
	    }
	    
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$fullfillment = SernoOutput::find()
		->select([
			'monthly_progress_plan' => 'SUM(CASE WHEN back_order=0 THEN qty ELSE 0 END)',
			'monthly_total_plan' => 'SUM(qty)'
		])
		->where([
			'id' => $searchModel->id
		])
		->one();

    	return $this->render('index', [
    		'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'fullfillment' => $fullfillment,
		    'period' => $searchModel->id
    	]);
    }
}