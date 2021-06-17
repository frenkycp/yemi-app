<?php

namespace app\controllers;

use yii\helpers\Url;

class PermitDataCenterController extends \app\controllers\base\PermitDataCenterController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionClose($ID)
	{
		$model = $this->findModel($ID);

		$model->STATUS = 'C';
		if ($model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return json_encode($model->errors);
		}
	}
}
