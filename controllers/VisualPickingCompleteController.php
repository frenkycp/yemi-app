<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\VisualPickingCompleteSearch;

class VisualPickingCompleteController extends Controller
{
    
	public function actionPts()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

		$searchModel  = new VisualPickingCompleteSearch;
		$searchModel->stage_id = 4;
		$searchModel->pts_stat = 'Y';
		$searchModel->req_date = date('Y-m-d');
		if(\Yii::$app->request->get('req_date') !== null)
	    {
	    	$searchModel->req_date = \Yii::$app->request->get('req_date');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('pts', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionNoPts()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

		$searchModel  = new VisualPickingCompleteSearch;
		$searchModel->stage_id = 4;
		$searchModel->pts_stat = 'N';
		$searchModel->req_date = date('Y-m-d');
		if(\Yii::$app->request->get('req_date') !== null)
	    {
	    	$searchModel->req_date = \Yii::$app->request->get('req_date');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('no-pts', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}
}