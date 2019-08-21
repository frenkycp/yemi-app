<?php

namespace app\controllers;

use yii\helpers\Url;

/**
* This is the class for controller "SapPoRcvController".
*/
class IncomingInspectionController extends \app\controllers\base\SapPoRcvController
{
	public function actionJudgement($material_document_number)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($material_document_number);
		$model->rcv_date = date('Y-m-d', strtotime($model->rcv_date));

		$model_judgement = new \yii\base\DynamicModel([
	        'judgement', 'remark'
	    ]);
	    $model_judgement->addRule(['judgement'], 'required')
	    ->addRule(['remark'], 'string');

	    if ($model->Judgement != null) {
			$model_judgement->judgement = $model->Judgement;
		}

		if ($model->Remark != null) {
			$model_judgement->remark = $model->Remark;
		}

		if ($model_judgement->load(\Yii::$app->request->post())) {
			$model->Judgement = $model_judgement->judgement;
			if ($model_judgement->remark != '') {
				$model->Remark = $model_judgement->remark;
			}

			if (!$model->save()) {
				return json_encode($model->errors);
			}

			return $this->redirect(Url::previous());
		} else {
			return $this->renderAjax('judgement', [
				'model' => $model,
				'model_judgement' => $model_judgement,
			]);
		}
	}
}
