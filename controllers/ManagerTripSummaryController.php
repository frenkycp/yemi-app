<?php

namespace app\controllers;

use app\models\BentolManagerTripSummary;
    use app\models\search\ManagerTripSummarySearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class ManagerTripSummaryController extends \app\controllers\base\ManagerTripSummaryController
{
	public function actionIndex()
	{
		$this->layout = 'clean';

	    $searchModel  = new ManagerTripSummarySearch;

	    $searchModel->post_date = date('Y-m-d', strtotime(' -1 day'));
	    if(\Yii::$app->request->get('post_date') !== null)
	    {
	    	$searchModel->post_date = \Yii::$app->request->get('post_date');
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
