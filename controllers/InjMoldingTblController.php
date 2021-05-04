<?php

namespace app\controllers;

use app\models\InjMoldingTbl;
use app\models\InjMoldingMaintenance;
use app\models\search\InjMoldingTblSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\Karyawan;

class InjMoldingTblController extends \app\controllers\base\InjMoldingTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new InjMoldingTblSearch;
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
		$model = new InjMoldingTbl;

		try {
			if ($model->load($_POST) && $model->save()) {
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

	public function actionUpdate($MOLDING_ID)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($MOLDING_ID);

		if ($model->load($_POST)) {
			$tmp_id = \Yii::$app->user->identity->username;
			$tmp_name = \Yii::$app->user->identity->name;
			$model->UPDATE_BY_ID = $tmp_id;
			$model->UPDATE_BY_NAME = $tmp_name;

			$tmp_user = Karyawan::find()->where([
				'OR',
				['NIK' => $tmp_id],
				['NIK_SUN_FISH' => $tmp_id]
			])->one();

			if ($tmp_user) {
				$model->UPDATE_BY_ID = $tmp_user->NIK_SUN_FISH;
				$model->UPDATE_BY_NAME = $tmp_user->NAMA_KARYAWAN;
			}
			$model->UPDATE_DATETIME = date('Y-m-d H:i:s');

			if ($model->TOTAL_COUNT > $model->NEXT_MAINTENANCE) {
				$multiply = ceil(($model->TOTAL_COUNT / $model->TARGET_COUNT));
				$model->NEXT_MAINTENANCE = $multiply * $model->TARGET_COUNT;
			}

			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionMaintainPause($MOLDING_ID, $IS_PAUSE)
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

		$molding_maintenance = InjMoldingMaintenance::find()->where([
			'MOLDING_ID' => $MOLDING_ID,
			'STATUS' => 'O'
		])->one();

		$molding_maintenance->IS_PAUSE = $IS_PAUSE;
		$end_time = date('Y-m-d H:i:s');
		if ($IS_PAUSE == 1) {
			$start_time = $molding_maintenance->CHECK_POINT;
			
			$diff_s = strtotime($end_time) - strtotime($start_time);
			$molding_maintenance->TOTAL_TIME += $diff_s;
		}
		$molding_maintenance->CHECK_POINT = $end_time;

		if (!$molding_maintenance->save()) {
			return json_encode($molding_maintenance->errors);
		}

		return [];
	}

	public function actionMaintainGetTime($MOLDING_ID = '')
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

		$molding_maintenance = InjMoldingMaintenance::find()->where([
			'MOLDING_ID' => $MOLDING_ID,
			'STATUS' => 'O'
		])->one();
		$start_time = new \DateTime($molding_maintenance->CHECK_POINT);
		
		if ($molding_maintenance->IS_PAUSE == 1) {
			$end_time = new \DateTime($molding_maintenance->CHECK_POINT);
		} else {
			$end_time = new \DateTime(date('Y-m-d H:i:s'));
		}
		$start_time->modify('-' . $molding_maintenance->TOTAL_TIME . ' second');
		$interval = $start_time->diff($end_time);
		$total_hour = $interval->d * 24;
        $total_hour += $interval->h;
        $total_minute = $interval->i;
        $total_second = $interval->s;
		$time_txt = str_pad($total_hour, 2, '0', STR_PAD_LEFT) . ' h : ' . str_pad($total_minute, 2, '0', STR_PAD_LEFT) . ' m : ' . str_pad($total_second, 2, '0', STR_PAD_LEFT) . ' s';

		return [
			'time_txt' => $time_txt,
			'is_pause' => $molding_maintenance->IS_PAUSE
		];
	}

	public function actionMaintain($MOLDING_ID = '')
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = InjMoldingMaintenance::find()->where([
			'MOLDING_ID' => $MOLDING_ID,
			'STATUS' => 'O'
		])->one();
		$tmp_molding = $this->findModel($MOLDING_ID);
		if ($tmp_molding->MOLDING_STATUS == 1) {
			\Yii::$app->session->setFlash("warning", "Molding is not ready...");
			return $this->redirect(Url::previous());
		}
		$tmp_molding->MOLDING_STATUS = 2;

		if (!$model) {
			$tmp_molding->save();
			$model = new InjMoldingMaintenance;
			$model->MOLDING_ID = $tmp_molding->MOLDING_ID;
			$model->MOLDING_NAME = $tmp_molding->MOLDING_NAME;

			$tmp_id = \Yii::$app->user->identity->username;
			$tmp_name = \Yii::$app->user->identity->name;
			$model->PIC_ID = $tmp_id;
			$model->PIC_NAME = $tmp_name;

			$tmp_user = Karyawan::find()->where([
				'OR',
				['NIK' => $tmp_id],
				['NIK_SUN_FISH' => $tmp_id]
			])->one();

			if ($tmp_user) {
				$model->PIC_ID = $tmp_user->NIK_SUN_FISH;
				$model->PIC_NAME = $tmp_user->NAMA_KARYAWAN;
			}
			
			$model->START_MAINTENANCE = $model->CHECK_POINT = date('Y-m-d H:i:s');
			$model->save();

			return $this->render('maintain', [
				'model' => $model,
			]);
		}

		$tmp_id = \Yii::$app->user->identity->username;
		$tmp_name = \Yii::$app->user->identity->name;
		$model->PIC_ID = $tmp_id;
		$model->PIC_NAME = $tmp_name;

		$tmp_user = Karyawan::find()->where([
			'OR',
			['NIK' => $tmp_id],
			['NIK_SUN_FISH' => $tmp_id]
		])->one();

		if ($tmp_user) {
			$model->PIC_ID = $tmp_user->NIK_SUN_FISH;
			$model->PIC_NAME = $tmp_user->NAMA_KARYAWAN;
		}

		if ($model->load($_POST)) {
			$start_time = $model->CHECK_POINT;
			$end_time = date('Y-m-d H:i:s');
			$model->TOTAL_TIME += strtotime($end_time) - strtotime($start_time);
			$model->STATUS = 'C';
			if ($model->save()) {
				$tmp_molding->MOLDING_STATUS = 0;
				$tmp_molding->NEXT_MAINTENANCE = $tmp_molding->TOTAL_COUNT + $tmp_molding->TARGET_COUNT;
				$tmp_molding->save();
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}
			
		} else {
			return $this->render('maintain', [
				'model' => $model,
			]);
		}
	}
}
