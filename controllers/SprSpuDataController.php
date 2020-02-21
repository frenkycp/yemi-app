<?php

namespace app\controllers;

use app\models\search\SprSpuDataSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class SprSpuDataController extends \app\controllers\base\SprSpuDataController
{
	public function actionIndex()
	{
	    $searchModel  = new SprSpuDataSearch;
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
