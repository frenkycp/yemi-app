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

	    $jabatan_arr = [
    		'01-NON POSITION' => 'NON POSITION',
    		'02-SUBLEADER' => 'SUBLEADER',
			'03-LEADER' => 'LEADER',
			'04-FOREMAN/CHIEF' => 'FOREMAN/CHIEF',
			'05-SENIOR FOREMAN/ASSISTANT MANAGER' => 'SENIOR FOREMAN/ASSISTANT MANAGER',
			'06-MANAGER' => 'MANAGER',
			'07-DEPUTY GM' => 'DEPUTY GM',
			'08-GM' => 'GM',
			'09-GM&DIRECTOR' => 'GM&DIRECTOR'
    	];
	    
	    if (\Yii::$app->request->get('period') !== null) {
	    	$searchModel->PERIOD = \Yii::$app->request->get('period');
	    }

	    if ($searchModel->PERIOD === null) {
	    	$searchModel->PERIOD = date('Ym');
	    }

	    if (\Yii::$app->request->get('tanggal') !== null) {
	    	$searchModel->TANGGAL = \Yii::$app->request->get('tanggal');
	    } else {
	    	$searchModel->AKHIR_BULAN = 'end_of_month';
	    }

	    if (\Yii::$app->request->get('jabatan') !== null) {
	    	$searchModel->JABATAN_SR_GROUP = \Yii::$app->request->get('jabatan');
	    }

	    if (\Yii::$app->request->get('category') !== null) {
	    	$searchModel->PKWT = \Yii::$app->request->get('category');
	    }

	    if (\Yii::$app->request->get('department') !== null) {
	    	$searchModel->DEPARTEMEN = \Yii::$app->request->get('department');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'jabatan_arr' => $jabatan_arr
		]);
	}
}