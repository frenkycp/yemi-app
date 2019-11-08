<?php

namespace app\controllers;

use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\search\ProdPlanDataSearch;
use app\models\BeaconTbl;

/**
* This is the class for controller "ProdPlanDataController".
*/
class ProdPlanDataController extends \app\controllers\base\ProdPlanDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    /**
	* Lists all WipEffTbl models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new ProdPlanDataSearch;

	    $searchModel->plan_date = date('Y-m-d');
	    if(\Yii::$app->request->get('plan_date') !== null)
	    {
	    	$searchModel->plan_date = \Yii::$app->request->get('plan_date');
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

	public function actionUpdate($lot_id)
	{
		$model = $this->findModel($lot_id);

		if ($model->load($_POST)) {
			$tmp_beacon = BeaconTbl::find()
			->where([
				'lot_number' => $lot_id
			])
			->one();
			if ($tmp_beacon->id != null) {
				$tmp_beacon->next_process = $model->jenis_mesin;
				if (!$tmp_beacon->save()) {
					return json_encode($tmp_beacon->errors);
				}
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
}
