<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\ProdPlanDataSearch;

/**
* This is the class for controller "ProdPlanDataController".
*/
class ProdPlanDataController extends \app\controllers\base\ProdPlanDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    /**
	* Lists all WipEffTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new ProdPlanDataSearch;

	    $searchModel->plan_date = date('Y-m-d');
	    if(\Yii::$app->request->get('plan_date') !== null)
	    {
	    	$searchModel->plan_date = \Yii::$app->request->get('plan_date');
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
