<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

use app\models\search\NgSernoSearch;

/**
* This is the class for controller "NgSernoController".
*/
class NgSernoController extends \app\controllers\base\NgSernoController
{
	public function actionIndex()
	{
	    $searchModel  = new NgSernoSearch;

	    if(\Yii::$app->request->get('document_no') !== null)
	    {
	    	$searchModel->document_no = \Yii::$app->request->get('document_no');
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
