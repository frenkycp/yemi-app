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
		$model = $this->findModel($MOLDING_ID);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionMaintain($MOLDING_ID = '')
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = InjMoldingMaintenance::find()->where([
			'MOLDING_ID' => $MOLDING_ID,
			'STATUS' => 'O'
		])->one();

		if (!$model) {
			$tmp_molding = $this->findModel($MOLDING_ID);
			$model = new InjMoldingMaintenance;
			$model->MOLDING_ID = $tmp_molding->MOLDING_ID;
			$model->MOLDING_NAME = $tmp_molding->MOLDING_NAME;
			$model->PIC_ID = \Yii::$app->user->identity->username;
			$model->PIC_NAME = \Yii::$app->user->identity->name;
			$model->START_MAINTENANCE = $model->CHECK_POINT = date('Y-m-d H:i:s');
			$model->save();
		}

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('maintain', [
				'model' => $model,
			]);
		}
	}
}
