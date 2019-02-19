<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use yii\web\Controller;
use app\models\search\PartSupplementDetailDataSearch;

/**
* This is the class for controller "PartSupplementData".
*/
class PartSupplementDetailDataController extends Controller
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
	    $searchModel  = new PartSupplementDetailDataSearch;
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
