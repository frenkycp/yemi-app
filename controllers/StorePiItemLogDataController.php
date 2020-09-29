<?php

namespace app\controllers;

use app\models\StorePiItemLog;
use app\models\search\StorePiItemLogDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class StorePiItemLogDataController extends \app\controllers\base\StorePiItemLogDataController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
	    $searchModel  = new StorePiItemLogDataSearch;
	    $searchModel->PI_MISTAKE = 'N';
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
