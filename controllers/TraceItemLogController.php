<?php

namespace app\controllers;

use app\models\TraceItemDtrLog;
    use app\models\search\TraceItemLogSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class TraceItemLogController extends \app\controllers\base\TraceItemLogController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
	    $searchModel  = new TraceItemLogSearch;
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
