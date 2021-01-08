<?php

namespace app\controllers;

use yii\helpers\Url;
use app\models\MachineStopRecord;
use app\models\Karyawan;
use app\models\MachineIotCurrent;

class MachineStopRecordController extends \app\controllers\base\MachineStopRecordController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new MachineStopRecord;
		$model->START_TIME = date('Y-m-d H:i');

		try {
			if ($model->load($_POST)) {
				//return $this->redirect(['view', 'ID' => $model->ID]);
				$nik = \Yii::$app->user->identity->username;
				$tmp_user = Karyawan::find()->where([
					'OR',
					['NIK' => $nik],
					['NIK_SUN_FISH' => $nik]
				])->one();

				if ($tmp_user) {
					$model->START_BY_ID = $tmp_user->NIK_SUN_FISH;
					$model->START_BY_NAME = $tmp_user->NAMA_KARYAWAN;
					$model->PERIOD = date('Ym', strtotime($model->START_TIME));
					$model->POST_DATE = date('Y-m-d', strtotime($model->START_TIME));

					$tmp_machine = MachineIotCurrent::find()->where([
						'mesin_id' => $model->MESIN_ID
					])->one();
					$model->MESIN_DESC = $tmp_machine->mesin_description;

					if ($model->save()) {
						return $this->redirect(Url::previous());
					} else {
						return json_encode($model->errors);
					}
				} else {
					\Yii::$app->session->setFlash("warning", "User is not registered! Please contact administrator ...");
				}
				
				
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}

	public function actionEndTime($ID)
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = $this->findModel($ID);
		$model->END_TIME = date('Y-m-d H:i');

		if ($model->load($_POST)) {

			$nik = \Yii::$app->user->identity->username;
			$tmp_user = Karyawan::find()->where([
				'OR',
				['NIK' => $nik],
				['NIK_SUN_FISH' => $nik]
			])->one();

			if ($tmp_user) {
				$model->END_BY_ID = $tmp_user->NIK_SUN_FISH;
				$model->END_BY_NAME = $tmp_user->NAMA_KARYAWAN;
				$model->TOTAL_DOWNTIME = strtotime($model->END_TIME) - strtotime($model->START_TIME);
			} else {
				\Yii::$app->session->setFlash("warning", "User is not registered! Please contact administrator ...");
			}

			$model->STATUS = 1;

			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}
		}

		return $this->render('end-time', [
			'model' => $model
		]);
	}
}
