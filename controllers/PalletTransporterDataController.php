<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\PalletTransporterDataSearch;

/**
* This is the class for controller "PalletTransporterDataController".
*/
class PalletTransporterDataController extends \app\controllers\base\PalletTransporterDataController
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Lists all SernoSlipLog models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new PalletTransporterDataSearch;
	    $searchModel->order_date = date('Y-m-d');
	    if(\Yii::$app->request->get('etd') !== null)
	    {
	    	$searchModel->order_date = \Yii::$app->request->get('etd');
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