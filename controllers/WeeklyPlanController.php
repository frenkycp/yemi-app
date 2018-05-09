<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\WeeklyPlanSearch;

/**
* This is the class for controller "WeeklyPlanController".
*/
class WeeklyPlanController extends \app\controllers\base\WeeklyPlanController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

	    $searchModel  = new WeeklyPlanSearch;
	    $searchModel->period = date('Ym');
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
