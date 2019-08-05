<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\WeeklyPlanSearch;
use app\models\WeeklyPlan;

/**
* This is the class for controller "WeeklyPlanController".
*/
class WeeklyPlanController extends \app\controllers\base\WeeklyPlanController
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

	    $searchModel  = new WeeklyPlanSearch;
	    $searchModel->period = date('Ym');
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
		'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCreate()
	{
		$model = new WeeklyPlan;
		$model->category = 'ETD_YEMI';

		try {
			if ($model->load($_POST)) {
				$tmp_data = WeeklyPlan::find()
				->where([
					'period' => $model->period,
					'week' => $model->week
				])
				->one();
				if ($tmp_data->id != null) {
					\Yii::$app->session->setFlash("danger", 'Period and Week is already exist! Please input another value ...');
					return $this->render('create', ['model' => $model]);
				}
				
				$balance_export = (int)$model->actual_export - (int)$model->plan_export;
				$model->balance_export = $balance_export;
				if (!$model->save()) {
					return json_encode($model->errors);
				}
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST)) {
			$balance_export = (int)$model->actual_export - (int)$model->plan_export;
			$model->balance_export = $balance_export;
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
