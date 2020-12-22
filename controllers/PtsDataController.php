<?php

namespace app\controllers;

use app\models\search\PtsDataSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class PtsDataController extends \app\controllers\base\PtsDataController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
	    $searchModel  = new PtsDataSearch;
	    $searchModel->status = 'D';
	    $searchModel->pts = 'Y';

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
