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
use dmstr\bootstrap\Tabs;

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

    public function actionIndex()
	{
	    $searchModel  = new AuditPatrolSearch;
	    $searchModel->FLAG = 1;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
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
					$model->CC_GROUP = $tmp_cc->CC_GROUP;
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
					if ($model->upload_before_1) {
						$new_filename_b1 = $model->ID . '_BEFORE_1.' . $model->upload_before_1->extension;
						$filePath_b1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_b1;
						$model->upload_before_1->saveAs($filePath_b1);
						Image::getImagine()->open($filePath_b1)->thumbnail(new Box(1920, 1080))->save($filePath_b1 , ['quality' => 90]);
						AuditPatrolTbl::UpdateAll(['IMAGE_BEFORE_1' => $new_filename_b1], ['ID' => $model->ID]);
					}
					
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

	public function sendEmail($model)
	{
		//$tmp_patrol = TraceItemScrap::find()->where(['SERIAL_NO' => $SERIAL_NO])->one();
		$category = \Yii::$app->params['audit_patrol_category'][$model->CATEGORY];
		$msg = '
		<div style="text-align: center">
			Patrol Presdir & General Manager<br/>
			(Last Update : ' . date('d-M-Y H:i:s', strtotime($model->PATROL_DATETIME)) . ')<br/><br/>
			<span style="font-size: 0.5em;">This is an automatic notification. Please do not reply to this address.</span><br/><br/>
			Patrol Presdir & GM<br/><br/>
			Permasalahan :<br/>
			' . $model->DESCRIPTION . '<br/><br/>
			Kategori : ' . $category . '<br/><br/>
		</div>
        <table>
        	<thead>
        		<tr>
        			<th>Point</th>
        			<th>Content</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td>Auditor</td>
        			<td>' . $model->AUDITOR . '</td>
        		</tr>
        		<tr>
        			<td>Tanggal</td>
        			<td>' . date('d F Y', strtotime($model->PATROL_DATE)) . '</td>
        		</tr>
        		<tr>
        			<td>Lokasi</td>
        			<td>' . $model->CC_DESC . '</td>
        		</tr>
        		<tr>
        			<td>Detail Lokasi</td>
        			<td>' . $model->LOC_DETAIL . '</td>
        		</tr>
        		<tr>
        			<td>Auditee</td>
        			<td>' . $model->PIC_NAME . '</td>
        		</tr>
        	</tbody>
        </table>
        <br/>
        Thanks & Best Regards,<br/>
        MITA
        ';

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $msg
        ])
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['frenky.purnama@music.yamaha.com', 'angga.adhitya@music.yamaha.com','fredy.agus@music.yamaha.com'])
        //->setCc($set_to_cc_arr)
        ->setSubject('Order Request')
        ->send();
	}

	public function actionDeleteData($ID){
		$model = $this->findModel($ID);

		if ($model->load(\Yii::$app->request->post())) {
			date_default_timezone_set('Asia/Jakarta');
			$model->FLAG = 0;
			$user_id = \Yii::$app->user->identity->username;
			$model->DELETE_BY_ID = $model->DELETE_BY_NAME = $user_id;
			$model->DELETE_DATETIME = date('Y-m-d H:i:s');

			$tmp_user = Karyawan::find()
			->where([
				'OR',
				['NIK' => $user_id],
				['NIK_SUN_FISH' => $user_id]
			])
			->one();
			if ($tmp_user) {
				$model->DELETE_BY_NAME = $tmp_user->NAMA_KARYAWAN;
			}

			if ($model->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}

			//return $this->redirect(Url::previous());
		}

		return $this->renderAjax('delete-data', [
    		'model' => $model
    	]);
	}

	public function actionSolve($ID){
		$model = $this->findModel($ID);
		$custom_model = new \yii\base\DynamicModel([
            'ID', 'ACTION', 'upload_after_1'
        ]);

        if ($model->IMAGE_AFTER_1 == null) {
        	$custom_model->addRule(['ID', 'ACTION', 'upload_after_1'], 'required');
        } else {
        	$custom_model->addRule(['ID', 'ACTION'], 'required');
        }
        
        $custom_model->ID = $ID;
        $custom_model->upload_after_1 = $model->IMAGE_AFTER_1;

		if ($custom_model->load($_POST)) {
			$model->STATUS = 'C';
			$model->ACTION = $custom_model->ACTION;
			if ($model->save()) {
				$custom_model->upload_after_1 = UploadedFile::getInstance($custom_model, 'upload_after_1');
				if ($custom_model->upload_after_1) {
					$new_filename_a1 = $custom_model->ID . '_AFTER_1.' . $custom_model->upload_after_1->extension;
					$filePath_a1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_a1;
					$custom_model->upload_after_1->saveAs($filePath_a1);
					Image::getImagine()->open($filePath_a1)->thumbnail(new Box(1920, 1080))->save($filePath_a1 , ['quality' => 90]);
					AuditPatrolTbl::UpdateAll(['IMAGE_AFTER_1' => $new_filename_a1], ['ID' => $custom_model->ID]);
				}
				
				return $this->redirect(Url::previous());
			}
		} else {
			return $this->render('solve', [
				'model' => $model,
				'custom_model' => $custom_model,
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
				$model->CC_GROUP = $tmp_cc->CC_GROUP;
			}
			
			if ($model->save()) {
				$model->upload_before_1 = UploadedFile::getInstance($model, 'upload_before_1');
				if ($model->upload_before_1) {
					$new_filename_b1 = $model->ID . '_BEFORE_1.' . $model->upload_before_1->extension;
					$filePath_b1 = \Yii::getAlias("@app/web/uploads/AUDIT_PATROL/") . $new_filename_b1;
					$model->upload_before_1->saveAs($filePath_b1);
					Image::getImagine()->open($filePath_b1)->thumbnail(new Box(1920, 1080))->save($filePath_b1 , ['quality' => 90]);
					AuditPatrolTbl::UpdateAll(['IMAGE_BEFORE_1' => $new_filename_b1], ['ID' => $model->ID]);
				}
				
				return $this->redirect(Url::previous());
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
