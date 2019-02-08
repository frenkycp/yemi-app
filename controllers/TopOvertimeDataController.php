<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\TopOvertimeDataSearch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "PartSupplementData".
*/
class TopOvertimeDataController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
	/**
	* Lists all AssetTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
		$searchModel  = new TopOvertimeDataSearch;

		$year = date('Y');
        $month = date('m');

        $searchModel->PERIOD = $year . $month;
        
        if (\Yii::$app->request->get('PERIOD') !== null) {
			$searchModel->PERIOD = \Yii::$app->request->get('PERIOD');
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
