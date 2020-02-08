<?php

namespace app\controllers;

use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\ItemUncounttableDataSearch;

class ItemUncounttableDataController extends \app\controllers\base\ItemUncounttableDataController
{
	public function actionIndex()
	{
		$searchModel  = new ItemUncounttableDataSearch;
		$searchModel->POST_DATE = '2020-02-07';
		if(\Yii::$app->request->get('POST_DATE') !== null)
	    {
	    	$searchModel->POST_DATE = \Yii::$app->request->get('POST_DATE');
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
