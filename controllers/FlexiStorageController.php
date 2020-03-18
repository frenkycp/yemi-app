<?php

namespace app\controllers;

use app\models\search\FlexiStorageSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class FlexiStorageController extends \app\controllers\base\FlexiStorageController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
	    $searchModel  = new FlexiStorageSearch;
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
