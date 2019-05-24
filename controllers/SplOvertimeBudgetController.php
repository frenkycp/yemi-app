<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;

use app\models\search\SplOvertimeBudgetSearch;

class SplOvertimeBudgetController extends \app\controllers\base\SplOvertimeBudgetController
{
	public function actionIndex()
	{
	    $searchModel  = new SplOvertimeBudgetSearch;
	    $searchModel->period = date('Ym');
	    if (\Yii::$app->request->get('period') != null) {
	    	$searchModel->period = \Yii::$app->request->get('period');
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
