<?php

namespace app\controllers;

use app\models\AssetDtrTbl;
    use app\models\search\SubFixAssetSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class SubFixAssetController extends \app\controllers\base\SubFixAssetController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionUpdate($fixed_asset_subid)
	{
		$model = $this->findModel($fixed_asset_subid);
		if ($model->dateacqledger != null) {
			$model->dateacqledger = date('Y-m-d', strtotime($model->dateacqledger));
		}
		
		if ($model->depr_date != null) {
			$model->depr_date = date('Y-m-d', strtotime($model->depr_date));
		}

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
