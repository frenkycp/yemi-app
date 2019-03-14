<?php

namespace app\controllers;

use app\models\MntShiftSch;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\MntShiftSchSearch;

/**
* This is the class for controller "MntShiftSchController".
*/
class MntShiftSchController extends \app\controllers\base\MntShiftSchController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Creates a new MntShiftSch model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/

	/**
	* Lists all MntShiftSch models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new MntShiftSchSearch;
	    $searchModel->shift_date = date('Y-m-d');
	    if (\Yii::$app->request->post('shift_date') != null) {
	    	$searchModel->shift_date = \Yii::$app->request->post('shift_date');
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

	public function actionAddMultiple()
	{
		
	}

	public function actionCreate()
	{
		$model = new MntShiftSch;

		try {
			if ($model->load($_POST)) {
				$to_find = MntShiftSch::find()
				->where(['shift_emp_id' => $model->shift_emp_id, 'shift_date' => $model->shift_date])
				->one();
				if ($to_find !== null) {
					\Yii::$app->session->addFlash("danger", "Can't save to database. The user has been added to that date.");
				} else {
					$period = date('Ym', strtotime($model->shift_date));
					$model->period = $period;
					if ($model->save()) {
						return $this->redirect(Url::previous());
					} else {
						return json_encode($model->error());
					}
				}
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	/**
	* Updates an existing MntShiftSch model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id
	* @return mixed
	*/
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST)) {
			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->error());
			}
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
