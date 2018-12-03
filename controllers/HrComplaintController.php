<?php

namespace app\controllers;

use yii\helpers\Url;

/**
* This is the class for controller "HrComplaintController".
*/
class HrComplaintController extends \app\controllers\base\HrComplaintController
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

		if ($model->load($_POST)) {
			$model->status = 1;
			$model->response_datetime = date('Y-m-d H:i:s');
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
