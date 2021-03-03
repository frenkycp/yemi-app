<?php

namespace app\controllers;

use app\models\AuditPatrolTbl;
use app\models\search\AuditPatrolSearch;
use yii\helpers\Url;
use app\models\SunfishViewEmp;
use app\models\Karyawan;
use app\models\CostCenter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
* This is the class for controller "AuditPatrolController".
*/
class AuditPatrolController extends \app\controllers\base\AuditPatrolController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new AuditPatrolTbl;
		$model->AUDITOR = 'Hiroshi Ura';
		$model->PATROL_DATE = date('Y-m-d');

		try {
			if ($model->load($_POST)) {
				$model->PATROL_PERIOD = date('Ym', strtotime($model->PATROL_DATE));
				$model->PATROL_DATETIME = date('Y-m-d H:i:s');
				// $model->LOC_DESC = \Yii::$app->params['wip_location_arr'][$model->LOC_ID];
				if ($model->PIC_ID != null && $model->PIC_ID != '') {
					$tmp_pic = SunfishViewEmp::find()->where(['Emp_no' => $model->PIC_ID])->one();
					$model->PIC_NAME = $tmp_pic->Full_name;
				}

				if ($model->CC_ID != null && $model->CC_ID != '') {
					$tmp_cc = CostCenter::find()->where(['CC_ID' => $model->CC_ID])->one();
					$model->CC_DESC = $tmp_cc->CC_DESC;
				}
				
				$model->USER_ID = $model->USER_NAME = \Yii::$app->user->identity->username;
				$tmp_user = Karyawan::find()
				->where([
					'OR',
					['NIK' => $model->USER_ID],
					['NIK_SUN_FISH' => $model->USER_ID]
				])
				->one();
				if ($tmp_user) {
					$model->USER_NAME = $tmp_user->NAMA_KARYAWAN;
				}

				if ($model->save()) {
					$model->upload_before_1 = UploadedFile::getInstance($model, 'upload_before_1');
					$new_filename_b1 = $model->ID . '_BEFORE_1.' . $model->upload_before_1->extension;
					$filePath_b1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_b1;
					$model->upload_before_1->saveAs($filePath_b1);
					Image::getImagine()->open($filePath_b1)->thumbnail(new Box(1920, 1080))->save($filePath_b1 , ['quality' => 90]);
					AuditPatrolTbl::UpdateAll(['IMAGE_BEFORE_1' => $new_filename_b1], ['ID' => $model->ID]);
					return $this->redirect(Url::previous());
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

	public function actionSolve($ID){
		$model = $this->findModel($ID);

		if ($model->load($_POST)) {
			$model->STATUS = 'C';
			if ($model->save()) {
				$model->upload_after_1 = UploadedFile::getInstance($model, 'upload_after_1');
				$new_filename_a1 = $model->ID . '_AFTER_1.' . $model->upload_after_1->extension;
				$filePath_a1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_a1;
				$model->upload_after_1->saveAs($filePath_a1);
				Image::getImagine()->open($filePath_a1)->thumbnail(new Box(1920, 1080))->save($filePath_a1 , ['quality' => 90]);
				AuditPatrolTbl::UpdateAll(['IMAGE_AFTER_1' => $new_filename_a1], ['ID' => $model->ID]);
				return $this->redirect(Url::previous());
			}
		} else {
			return $this->render('solve', [
				'model' => $model,
			]);
		}
	}

	public function actionUpdate($ID)
	{
		$model = $this->findModel($ID);

		if ($model->load($_POST)) {
			// $model->LOC_DESC = \Yii::$app->params['wip_location_arr'][$model->LOC_ID];
			if ($model->PIC_ID != null && $model->PIC_ID != '') {
				$tmp_pic = SunfishViewEmp::find()->where(['Emp_no' => $model->PIC_ID])->one();
				$model->PIC_NAME = $tmp_pic->Full_name;
			}

			if ($model->CC_ID != null && $model->CC_ID != '') {
				$tmp_cc = CostCenter::find()->where(['CC_ID' => $model->CC_ID])->one();
				$model->CC_DESC = $tmp_cc->CC_DESC;
			}
			
			if ($model->save()) {
				$model->upload_before_1 = UploadedFile::getInstance($model, 'upload_before_1');
				$new_filename_b1 = $model->ID . '_BEFORE_1.' . $model->upload_before_1->extension;
				$filePath_b1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_b1;
				$model->upload_before_1->saveAs($filePath_b1);
				Image::getImagine()->open($filePath_b1)->thumbnail(new Box(1920, 1080))->save($filePath_b1 , ['quality' => 90]);
				AuditPatrolTbl::UpdateAll(['IMAGE_BEFORE_1' => $new_filename_b1], ['ID' => $model->ID]);
				return $this->redirect(Url::previous());
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
