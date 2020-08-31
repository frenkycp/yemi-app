<?php

namespace app\controllers;

use app\models\BentolManagerTripSummary;
    use app\models\search\ManagerTripSummarySearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\WorkDayTbl;

class ManagerTripSummaryController extends \app\controllers\base\ManagerTripSummaryController
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		$tmp_workday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
        	'<',
            'FORMAT(cal_date, \'yyyy-MM-dd\')',
            date('Y-m-d')
        ])
        ->andWhere('holiday IS NULL')
        ->orderBy('cal_date DESC')
        ->one();

	    $searchModel  = new ManagerTripSummarySearch;

	    $searchModel->post_date = $tmp_workday->cal_date;
	    if(\Yii::$app->request->get('post_date') !== null)
	    {
	    	$searchModel->post_date = \Yii::$app->request->get('post_date');
	    }

	    $searchModel->account_type = 'MANAGER';
	    if(\Yii::$app->request->get('account_type') !== null)
	    {
	    	$searchModel->account_type = \Yii::$app->request->get('account_type');
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
