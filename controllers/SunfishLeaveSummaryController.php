<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SunfishLeaveSummary;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\SunfishLeaveSummarySearch;

class SunfishLeaveSummaryController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$searchModel  = new SunfishLeaveSummarySearch;
		$searchModel->valid_date = date('Y-m-d');
        if (\Yii::$app->request->get('valid_date') !== null) {
			$searchModel->valid_date = \Yii::$app->request->get('valid_date');
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