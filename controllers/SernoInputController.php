<?php

namespace app\controllers;

use app\models\search\SernoInputSearch;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\SernoInput;
use app\models\SernoOutput;

/**
* This is the class for controller "SernoInputController".
*/
class SernoInputController extends \app\controllers\base\SernoInputController
{
	/**
	* Lists all SernoInput models.
	* @return mixed
	*/
	public function actionIndex()
	{
		$data_gmc = [];
		$data_flo = [];
		$data_invoice = [];

		$data_gmc_arr = SernoInput::find()->select('gmc')->distinct()->orderBy('gmc')->asArray()->all();
		$data_flo_arr = SernoInput::find()->select('distinct(flo)')->where('flo <> 0')->orderBy('flo')->asArray()->all();
		$data_invoice_arr = SernoOutput::find()->select('distinct(invo)')->where('invo <> \'\'')->orderBy('invo')->asArray()->all();
		
		foreach ($data_gmc_arr as $key => $value) {
			$data_gmc[] = $value['gmc'];
		}

		foreach ($data_flo_arr as $key => $value) {
			$data_flo[] = $value['flo'];
		}

		foreach ($data_invoice_arr as $key => $value) {
			$data_invoice[] = $value['invo'];
		}

		if (\Yii::$app->request->get()) {
			$searchModel  = new SernoInputSearch;
		    if (\Yii::$app->request->get('status') !== null) {
		    	$searchModel->status = \Yii::$app->request->get('status');
		    }
		    $searchModel->proddate = date('Y-m-d');
		    if (\Yii::$app->request->get('proddate') !== null) {
		    	$searchModel->proddate = \Yii::$app->request->get('proddate');
		    }
		    $dataProvider = $searchModel->search($_GET);

			Tabs::clearLocalStorage();

			Url::remember();
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->render('index', [
				'dataProvider' => $dataProvider,
			    'searchModel' => $searchModel,
			    'data_gmc' => $data_gmc,
			    'data_flo' => $data_flo,
			    'data_invoice' => $data_invoice,
			]);
		} else {
			$searchModel  = new SernoInputSearch;
		    $searchModel->plan = '-';
		    $dataProvider = $searchModel->search($_GET);

			Tabs::clearLocalStorage();

			Url::remember();
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->render('index', [
				'dataProvider' => $dataProvider,
			    'searchModel' => $searchModel,
			    'data_gmc' => $data_gmc,
			    'data_flo' => $data_flo,
			    'data_invoice' => $data_invoice,
			]);
		}
	    
	}
}
