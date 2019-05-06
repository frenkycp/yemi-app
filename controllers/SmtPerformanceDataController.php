<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\SmtPerformanceDataSearch;

class SmtPerformanceDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$searchModel  = new SmtPerformanceDataSearch;

		$searchModel->period = date('Ym');
		if (\Yii::$app->request->get('period') !== null) {
			$searchModel->period = \Yii::$app->request->get('period');
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