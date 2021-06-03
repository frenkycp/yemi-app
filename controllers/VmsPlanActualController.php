<?php

namespace app\controllers;

use app\models\VmsPlanActual;
use app\models\search\VmsPlanActualSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class VmsPlanActualController extends \app\controllers\base\VmsPlanActualController
{
	public function actionIndex()
	{
	    $searchModel  = new VmsPlanActualSearch;

	    $searchModel->VMS_PERIOD = date('Ym');
	    if(\Yii::$app->request->get('VMS_PERIOD') !== null)
	    {
	    	$searchModel->VMS_PERIOD = \Yii::$app->request->get('VMS_PERIOD');
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
