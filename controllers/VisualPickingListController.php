<?php

namespace app\controllers;

use yii\helpers\Url;

/**
* This is the class for controller "VisualPickingListController".
*/
class VisualPickingListController extends \app\controllers\base\VisualPickingListController
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	/**
	* Deletes an existing VisualPickingList model.
	* If deletion is successful, the browser will be redirected to the 'index' page.
	* @param integer $seq_no
	* @return mixed
	*/
	public function actionDelete($seq_no)
	{
		try {
			$this->findModel($seq_no)->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$seq_no',',');
		if ($isPivot == true) {
			return $this->redirect(Url::previous());
		} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
			Url::remember(null);
			$url = \Yii::$app->session['__crudReturnUrl'];
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->redirect($url);
		} else {
			return $this->redirect(Url::previous());
		}
	}
}
