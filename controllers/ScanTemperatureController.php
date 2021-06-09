<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\KaryawanSuhuViewSearch;

class ScanTemperatureController extends \app\controllers\base\ScanTemperatureController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
	    $searchModel  = new KaryawanSuhuViewSearch;

	    /*$searchModel->POST_DATE = date('Y-m-d');
	    if(\Yii::$app->request->get('POST_DATE') !== null)
	    {
	    	$searchModel->POST_DATE = \Yii::$app->request->get('POST_DATE');
	    }*/

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
