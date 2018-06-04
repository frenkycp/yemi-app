<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\EmpDataSearch;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;


/**
 * summary
 */
class HrgaEmpDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
    public function actionIndex()
	{
	    $searchModel  = new EmpDataSearch;
	    $searchModel->AKHIR_BULAN = 'end_of_month';

	    if (\Yii::$app->request->get('period') !== null) {
	    	$searchModel->PERIOD = \Yii::$app->request->get('period');
	    }

	    if ($searchModel->PERIOD === null) {
	    	$searchModel->PERIOD = date('Ym');
	    }

	    if (\Yii::$app->request->get('category') !== null) {
	    	$searchModel->PKWT = \Yii::$app->request->get('category');
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