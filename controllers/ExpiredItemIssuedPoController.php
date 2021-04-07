<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

use app\models\TraceItemRequestPc;
use app\models\search\ExpiredItemIssuedPoSearch;

class ExpiredItemIssuedPoController extends \app\controllers\base\ExpiredItemIssuedPoController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
	    $searchModel  = new ExpiredItemIssuedPoSearch;
	    if(\Yii::$app->request->get('REQUEST_ID') !== null)
	    {
	    	$searchModel->REQUEST_ID = \Yii::$app->request->get('REQUEST_ID');
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
