<?php

namespace app\controllers;
use yii\helpers\Url;
use app\models\MesinCheckNgDtr;

/**
* This is the class for controller "MesinCheckNgDtrController".
*/
class MesinCheckNgDtrController extends \app\controllers\base\MesinCheckNgDtrController
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Creates a new MesinCheckNgDtr model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate($urutan)
	{
		$model = new MesinCheckNgDtr;

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
		$model->urutan = $urutan;
		return $this->render('create', ['model' => $model]);
	}
}
