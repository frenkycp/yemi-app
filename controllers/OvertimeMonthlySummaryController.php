<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\OvertimeMonthlySummarySearch;

class OvertimeMonthlySummaryController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$searchModel  = new OvertimeMonthlySummarySearch;

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