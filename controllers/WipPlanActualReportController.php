<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\WipPlanActualReportSearch;
use app\models\WipPlanActualReport;
use yii\helpers\ArrayHelper;

class WipPlanActualReportController extends Controller
{
    /**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;


	/**
	* Lists all CisClientIpAddress models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new WipPlanActualReportSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$tmp_location = ArrayHelper::map(WipPlanActualReport::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc');

		$status_arr = WipPlanActualReport::find()->select('distinct(stage)')->orderBy('stage ASC')->all();

		$tmp_status = [];
		foreach ($status_arr as $status) {
			$splitted_stage = explode('-', $status->stage);
			$tmp_status[$status->stage] = $splitted_stage[1];
		}

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $tmp_location,
		    'status_dropdown' => $tmp_status
		]);
	}
}