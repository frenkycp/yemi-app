<?php

namespace app\controllers;

use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\MesinCheckDtrSearch;

/**
* This is the class for controller "MesinCheckDtrController".
*/
class MesinCheckDtrController extends \app\controllers\base\MesinCheckDtrController
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new MesinCheckDtrSearch;
	    if (\Yii::$app->request->get('master_plan_maintenance') !== null) {
	    	$searchModel->master_plan_maintenance = \Yii::$app->request->get('master_plan_maintenance');
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

	public function actionWeeklyChart()
	{
		return $this->render('weekly-chart');
	}
}
