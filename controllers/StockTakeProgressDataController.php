<?php

namespace app\controllers;

use app\models\StoreOnhandWsus;
use app\models\search\StockTakeProgressDataSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class StockTakeProgressDataController extends \app\controllers\base\StockTakeProgressDataController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
	    $searchModel  = new StockTakeProgressDataSearch;
	    //$searchModel->PI_STAT = 'C';
	    $searchModel->PI = 'Y';
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
