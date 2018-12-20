<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\GojekOrderTblSearch;
use yii\web\Controller;

/**
* This is the class for controller "GojekOrderTblController".
*/
class GoPickingOrderDataController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/

    /**
	* Lists all GojekOrderTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new GojekOrderTblSearch;
	    $searchModel->source = 'MAT';
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
