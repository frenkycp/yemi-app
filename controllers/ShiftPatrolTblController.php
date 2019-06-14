<?php

namespace app\controllers;

use app\models\ShiftPatrolTbl;
use app\models\Karyawan;
use app\models\WipLocation;
use yii\web\UploadedFile;
use app\models\ImageFile;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\ShiftPatrolTblSearch;
use app\models\CostCenter;
use app\models\ShiftPatrolRejectHistory;

class ShiftPatrolTblController extends \app\controllers\base\ShiftPatrolTblController
{
	/**/public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function getSectionArr()
	{
		$tmp_arr = [
			'230IQA' => 'QUALITY ASSURANCE (IQA)',
			'230IPQA' => 'QUALITY ASSURANCE (IPQA)',
			'230FQA' => 'QUALITY ASSURANCE (FQA)',
		];
		//$cc = CostCenter::find()->select('CC_ID, CC_DESC')->where(['<>', 'CC_ID', '230'])->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all();
		$cc = CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all();
		foreach ($cc as $key => $value) {
			$tmp_arr[$value->CC_ID] =  $value->CC_DESC;
		}
		asort($tmp_arr);
		return $tmp_arr;
	}

	public function actionGetCostCenter($CC_ID)
	{
		$cc = CostCenter::find()->where(['CC_ID' => $CC_ID])->one();
		$return_str = '';
		if ($cc->CC_ID != null) {
			$return_str = $cc->CC_GROUP . '||' . $cc->CC_DESC;
		} else {
			if ($CC_ID == '230IQA') {
				$return_str = 'QUALITY ASSURANCE||QUALITY ASSURANCE (IQA)';
			} elseif ($CC_ID == '230IPQA') {
				$return_str = 'QUALITY ASSURANCE||QUALITY ASSURANCE (IPQA)';
			} else {
				$return_str = 'QUALITY ASSURANCE||QUALITY ASSURANCE (FQA)';
			}
		}
		return $return_str;
	}
    
	public function actionIndex()
	{
	    $searchModel  = new ShiftPatrolTblSearch;
	    if (\Yii::$app->request->get('status') !== null) {
	    	$searchModel->status = \Yii::$app->request->get('status');
	    }
	    if (\Yii::$app->request->get('CC_ID') !== null) {
	    	$searchModel->CC_ID = \Yii::$app->request->get('section_id');
	    }
	    if (\Yii::$app->request->get('due_date') !== null) {
	    	$searchModel->due_date = \Yii::$app->request->get('due_date');
	    }
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_arr' => $this->getLocationArr(),
		    'section_arr' => $this->getSectionArr(),
		]);
	}

	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new ShiftPatrolTbl;


		try {
			if ($model->load($_POST)) {
				$model->NIK = \Yii::$app->user->identity->username;
				$model->NAMA_KARYAWAN = strtoupper(\Yii::$app->user->identity->name);
				$karyawan = Karyawan::find()->where(['NIK' => $model->NIK])->one();
				$model->CC_ID = $karyawan->CC_ID;
				$model->CC_GROUP = $karyawan->DEPARTEMEN;
				$model->CC_DESC = $karyawan->SECTION;
				$model->input_time = date('Y-m-d H:i:s');

				$total_case = ShiftPatrolTbl::find()->count();
				$total_case++;
				$case_number = 'S2-P-' . str_pad($total_case, 6, '0', STR_PAD_LEFT);
				$model->case_no = $case_number;

				$model->upload_file1 = UploadedFile::getInstance($model, 'upload_file1');
				if ($model->validate()) {
					if ($model->upload_file1) {
						$new_filename1 = 'SHIFT_PATROL_BEFORE_' . $model->NIK . '_' . date('Ymd_His') . '.' . $model->upload_file1->extension;
						$model->img_filename1 = $new_filename1;
		        		$filePath = \Yii::getAlias("@app/web/uploads/SHIFT_PATROL/") . $new_filename1;
		        		if (!$model->upload_file1->saveAs($filePath)) {
		                    return $model->errors;
		                }
		                ImageFile::resize_crop_image($filePath, $filePath, 70, 800);
		        	}
				}

				$model->upload_file2 = UploadedFile::getInstance($model, 'upload_file2');
				if ($model->validate()) {
					if ($model->upload_file2) {
						$new_filename2 = 'SHIFT_PATROL_AFTER_' . $model->NIK . '_' . date('Ymd_His') . '.' . $model->upload_file2->extension;
						$model->img_filename2 = $new_filename2;
		        		$filePath = \Yii::getAlias("@app/web/uploads/SHIFT_PATROL/") . $new_filename2;
		        		if (!$model->upload_file2->saveAs($filePath)) {
		                    return $model->errors;
		                }
		                ImageFile::resize_crop_image($filePath, $filePath, 70, 800);
		        	}
				}

				if (!$model->save()) {
					return json_encode($model->errors);
				}
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', [
			'model' => $model,
			'location_arr' => $this->getLocationArr(),
			'section_arr' => $this->getSectionArr(),
		]);
	}

	public function actionUpdate($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		if ($model->load($_POST)) {
			$model->last_modified = date('Y-m-d H:i:s');
			$model->last_modified_by = \Yii::$app->user->identity->username;
			$model->upload_file1 = UploadedFile::getInstance($model, 'upload_file1');
			if ($model->validate()) {
				if ($model->upload_file1) {
					$new_filename1 = 'SHIFT_PATROL_BEFORE_' . $model->NIK . '_' . date('Ymd_His') . '.' . $model->upload_file1->extension;
					$model->img_filename1 = $new_filename1;
	        		$filePath = \Yii::getAlias("@app/web/uploads/SHIFT_PATROL/") . $new_filename1;
	        		if (!$model->upload_file1->saveAs($filePath)) {
	                    return $model->errors;
	                }
	                ImageFile::resize_crop_image($filePath, $filePath, 70, 800);
	        	}
			}

			$model->upload_file2 = UploadedFile::getInstance($model, 'upload_file2');
			if ($model->validate()) {
				if ($model->upload_file2) {
					$new_filename2 = 'SHIFT_PATROL_AFTER_' . $model->NIK . '_' . date('Ymd_His') . '.' . $model->upload_file2->extension;
					$model->img_filename2 = $new_filename2;
	        		$filePath = \Yii::getAlias("@app/web/uploads/SHIFT_PATROL/") . $new_filename2;
	        		if (!$model->upload_file2->saveAs($filePath)) {
	                    return $model->errors;
	                }
	                ImageFile::resize_crop_image($filePath, $filePath, 70, 800);
	        	}
			}
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
				'location_arr' => $this->getLocationArr(),
				'section_arr' => $this->getSectionArr(),
			]);
		}
	}

	public function actionReply($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		$model_reply = new \yii\base\DynamicModel([
	        'cause', 'countermeasure'
	    ]);
	    $model_reply->addRule(['cause','countermeasure'], 'required');
	    $model_reply->cause = $model->cause;
	    $model_reply->countermeasure = $model->countermeasure;

		if ($model_reply->load(\Yii::$app->request->post())) {
			if ($model->replied_datetime == null) {
				$model->replied_datetime = date('Y-m-d H:i:s');
				$model->replied_by_id = \Yii::$app->user->identity->username;
				$model->replied_by_name = \Yii::$app->user->identity->name;
				$model->status = 2;
			}
			$model->cause = $model_reply->cause;
			$model->countermeasure = $model_reply->countermeasure;
			
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
		} else {
			return $this->renderAjax('reply', [
				'model' => $model,
				'model_reply' => $model_reply,
			]);
		}
	}

	public function actionReject($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		$model->reject_remark = null;

		if ($model->load(\Yii::$app->request->post())) {
			$model->status = 3;
			$model->reject_answer = null;
			if ($model->save()) {
				$model_history = new ShiftPatrolRejectHistory();
				$model_history->reference_id = $id;
				$model_history->rejector_id = \Yii::$app->user->identity->username;
				$model_history->rejector_name = \Yii::$app->user->identity->name;
				$model_history->reject_remark = $model->reject_remark;
				$model_history->reject_datetime = date('Y-m-d H:i:s');
				if ($model_history->save()) {
					return $this->redirect(Url::previous());
				} else {
					return json_encode($model_history->errors);
				}
			} else {
				return json_encode($model->errors);
			}

			//return $this->redirect(Url::previous());
		}

		return $this->renderAjax('reject', [
    		'model' => $model
    	]);
	}

	public function actionAnswer($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		if ($model->load(\Yii::$app->request->post())) {
			$model->status = 2;
			if ($model->save()) {
				$model_history = ShiftPatrolRejectHistory::find()
				->where([
					'reference_id' => $id,
				])
				->andWhere('answerer_id IS NULL')
				->one();
				$model_history->answerer_id = \Yii::$app->user->identity->username;
				$model_history->answerer_name = \Yii::$app->user->identity->name;
				$model_history->answerer_remark = $model->reject_answer;
				$model_history->answerer_datetime = date('Y-m-d H:i:s');
				if ($model_history->save()) {
					return $this->redirect(Url::previous());
				} else {
					return json_encode($model_history->errors);
				}
			} else {
				return json_encode($model->errors);
			}

			//return $this->redirect(Url::previous());
		}

		return $this->renderAjax('answer', [
    		'model' => $model
    	]);
	}

	public function actionDueDate($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		$model_reply = new \yii\base\DynamicModel([
	        'due_date'
	    ]);
	    $model_reply->addRule(['due_date'], 'required');
	    $model_reply->due_date = $model->due_date != null ? date('Y-m-d', strtotime($model->due_date)) : null;

		if ($model_reply->load(\Yii::$app->request->post())) {
			$model->status = 4;
			$model->due_date = $model_reply->due_date;
			if (!$model->save()) {
				return json_encode($model->errors);
			}

			return $this->redirect(Url::previous());
		}

		return $this->renderAjax('due-date', [
    		'model' => $model,
    		'model_reply' => $model_reply
    	]);
	}

	public function actionClose($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		$model->status = 1;
		$model->closed_datetime = date('Y-m-d H:i:s');
		$model->closed_by_id = \Yii::$app->user->identity->username;
		$model->closed_by_name = \Yii::$app->user->identity->name;

		if (!$model->save()) {
			return json_encode($model->errors);
		}
		
		return $this->redirect(Url::previous());
	}

	public function getLocationArr()
	{
		$data_arr = [];
		$wip_location = WipLocation::find()
		->orderBy('child_analyst_desc')
		->all();

		foreach ($wip_location as $key => $value) {
			$data_arr[$value->child_analyst_desc] = $value->child_analyst_desc;
		}

		$data_arr['OTHER'] = 'OTHER';
		return $data_arr;
	}

	protected function findModel($id)
	{
		if (($model = ShiftPatrolTbl::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
