<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\WipHdrDtrSearch;
use app\models\WipPlanActualReport;
use app\models\WipDtr;
use app\models\WipLocation;
use yii\helpers\ArrayHelper;

class WipPlanActualReportController extends Controller
{
    /**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	/**
	* Lists all CisClientIpAddress models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new WipHdrDtrSearch;
	    $searchModel->period = date('Ym');
	    if(\Yii::$app->request->get('period') !== null)
	    {
	    	$searchModel->period = \Yii::$app->request->get('period');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		/*$tmp_location = ArrayHelper::map(WipLocation::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc');*/

		$tmp_location = \Yii::$app->params['wip_location_arr'];

		/*$status_arr = WipPlanActualReport::find()->select('distinct(stage)')->orderBy('stage ASC')->all();

		$tmp_status = [];
		foreach ($status_arr as $status) {
			$splitted_stage = explode('-', $status->stage);
			$tmp_status[$status->stage] = $splitted_stage[1] == 'HAND OVER' ? 'PULLED BY NEXT' : $splitted_stage[1];
		}*/

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $tmp_location,
		    //'status_dropdown' => $tmp_status
		]);
	}

	public function actionReason($dtr_id, $location, $model_group, $child, $child_desc, $qty)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($dtr_id);

		if ($model->load($_POST)) {
			$model->delay_last_update = date('Y-m-d H:i:s');
			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				print_r($model->errors);
			}
		}
		$model->delay_userid = \Yii::$app->user->identity->username;
		$model->delay_userid_desc = \Yii::$app->user->identity->name;
		return $this->render('update', [
            'model' => $model,
            'location' => $location,
            'child' => $child,
            'model_group' => $model_group,
            'child_desc' => $child_desc,
            'qty' => $qty,
        ]);
		
	}

	protected function findModel($dtr_id)
	{
		if (($model = WipDtr::findOne($dtr_id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}