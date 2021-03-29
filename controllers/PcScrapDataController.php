<?php

namespace app\controllers;

use app\models\search\PcScrapDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class PcScrapDataController extends \app\controllers\base\PcScrapDataController
{
	public function actionIndex()
	{
	    $searchModel  = new PcScrapDataSearch;

	    $searchModel->scrap_centre = 'Y';
	    $searchModel->period = date('Ym');
	    if(\Yii::$app->request->get('period') !== null)
	    {
	    	$searchModel->period = \Yii::$app->request->get('period');
	    }
	    if(\Yii::$app->request->get('storage_loc') !== null)
	    {
	    	$searchModel->storage_loc = \Yii::$app->request->get('storage_loc');
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
