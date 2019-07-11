<?php

namespace app\controllers;

use yii\helpers\Url;

use app\models\HrFacility;

/**
* This is the class for controller "HrFacilityController".
*/
class HrFacilityController extends \app\controllers\base\HrFacilityController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionAddResponse($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		$model->scenario = HrFacility::SCENARIO_ANSWER;

		if ($model->load($_POST)) {
			
			$model->status = 1;
			$model->response_datetime = date('Y-m-d H:i:s');
			$model->responder_id = \Yii::$app->user->identity->username;
			$model->responder_name = \Yii::$app->user->identity->name;
			if ($model->save()) {
				return $this->redirect(Url::previous());
			}
		} else {
			return $this->render('add-response', [
				'model' => $model,
			]);
		}
	}
}
