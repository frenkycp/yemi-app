<?php

namespace app\controllers;

use app\models\GojekTbl;
use yii\helpers\Url;

/**
* This is the class for controller "GojekDriverPresenceController".
*/
class GojekDriverPresenceController extends \app\controllers\base\GojekDriverPresenceController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionPresenceUpdate($GOJEK_ID)
	{
		$model = GojekTbl::find()->where([
    		'GOJEK_ID' => $GOJEK_ID
    	])->one();

		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash("success", "Update Successfull...");
			return $this->redirect(Url::previous());
		}
    		
		return $this->renderAjax('presence_update', [
    		'model' => $model
    	]);
	}

	public function actionResetValue()
	{
		$rows = GojekTbl::updateAll(['GOJEK_VALUE' => 0]);
		\Yii::$app->getSession()->setFlash('success', 'Reset value succeeded...');
		return $this->redirect(Url::previous());
	}
}
