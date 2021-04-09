<?php

namespace app\controllers;

use app\models\search\PcScrapDataGroupingSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class PcScrapDataGroupingController extends Controller
{
	public function actionIndex()
	{
	    $searchModel  = new PcScrapDataGroupingSearch;

	    $searchModel->period = date('Ym');
	    if(\Yii::$app->request->get('period') !== null)
	    {
	    	$searchModel->period = \Yii::$app->request->get('period');
	    }
	    if(\Yii::$app->request->get('storage_loc_new') !== null)
	    {
	    	$searchModel->storage_loc_new = \Yii::$app->request->get('storage_loc_new');
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
