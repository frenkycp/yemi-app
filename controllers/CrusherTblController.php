<?php

namespace app\controllers;

use app\models\CrusherTbl;
use app\models\CrusherBomModel;
use yii\helpers\Url;

class CrusherTblController extends \app\controllers\base\CrusherTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new CrusherTbl;

		try {
			$model->created_datetime = date('Y-m-d H:i:s');
			$model->created_by_id = \Yii::$app->user->identity->username;
			$model->created_by_name = \Yii::$app->user->identity->name;

			if ($model->load($_POST)) {
				$tmp_bom = CrusherBomModel::find()->where(['model_name' => $model->model, 'part_type' => $model->part])->one();
				$model->bom = $model->consume = 0;
				if ($tmp_bom->id != null) {
					$bom_qty = $tmp_bom->bom_qty;
					$model->bom = $bom_qty;
					$model->consume = round($bom_qty * $model->qty, 3);
				}
				if ($model->save()) {
					return $this->redirect(Url::previous());
				} elseif (!\Yii::$app->request->isPost) {
					$model->load($_GET);
				}
			}

			
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}
}
