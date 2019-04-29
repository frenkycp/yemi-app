<?php

namespace app\controllers;

use app\models\IpqaPatrolTbl;
use app\models\IpqaCategoryTbl;
use app\models\SernoMaster;
use app\models\ImageFile;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use yii\web\UploadedFile;

class IpqaPatrolTblController extends \app\controllers\base\IpqaPatrolTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new IpqaPatrolTbl;
		$model->event_date = date('Y-m-d');
		$model->inspector_id = \Yii::$app->user->identity->username;
		$model->inspector_name = \Yii::$app->user->identity->name;
		$model->input_datetime = date('Y-m-d H:i:s');

		try {
			if ($model->load($_POST)) {
				$model->period = date('Ym', strtotime($model->event_date));
				$model->line_pic = strtoupper($model->line_pic);
				$model->inspector_name = strtoupper($model->inspector_name);

				//upload file
				$model->upload_file1 = UploadedFile::getInstance($model, 'upload_file1');
				if ($model->validate()) {
					if ($model->upload_file1) {
						$new_filename1 = 'IPQA_PATROL_' . date('Ymd_His') . '.' . $model->upload_file1->extension;
						$model->filename1 = $new_filename1;
		        		$filePath = \Yii::getAlias("@app/web/uploads/IPQA_PATROL/") . $new_filename1;
		        		if (!$model->upload_file1->saveAs($filePath)) {
		                    return $model->errors;
		                }
		                ImageFile::resize_crop_image($filePath, $filePath, 50, 800);
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
		return $this->render('create', ['model' => $model]);
	}

	/**
	* Updates an existing IpqaPatrolTbl model.
	* If update is successful, the browser will be redirected to the 'view' page.
	* @param integer $id
	* @return mixed
	*/
	public function actionUpdate($id)
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = $this->findModel($id);

		if ($model->load($_POST)) {
			$model->period = date('Ym', strtotime($model->event_date));
			$model->line_pic = strtoupper($model->line_pic);

			//upload file
			$model->upload_file1 = UploadedFile::getInstance($model, 'upload_file1');
			if ($model->validate()) {
				if ($model->upload_file1) {
					$new_filename1 = 'IPQA_PATROL_' . date('Ymd_His') . '.' . $model->upload_file1->extension;
					$model->filename1 = $new_filename1;
	        		$filePath = \Yii::getAlias("@app/web/uploads/IPQA_PATROL/") . $new_filename1;
	        		if (!$model->upload_file1->saveAs($filePath)) {
	                    return $model->errors;
	                }
	                ImageFile::resize_crop_image($filePath, $filePath, 50, 800);
	        	}
			}

			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
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

		if ($model_reply->load(\Yii::$app->request->post())) {
			$model->close_datetime = date('Y-m-d H:i:s');
			$model->closed_by = strtoupper(\Yii::$app->user->identity->name);
			$model->cause = $model_reply->cause;
			$model->countermeasure = $model_reply->countermeasure;
			$model->status = 1;
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
		} else {
			return $this->render('reply', [
				'model' => $model,
				'model_reply' => $model_reply,
			]);
		}
	}

	public function actionGmcInfo($gmc)
	{
		$speaker_model = SernoMaster::findOne(['gmc' => $gmc]);
		return $speaker_model->model . '||' . $speaker_model->color . '||' . $speaker_model->dest;
	}

	public function actionLists($category)
	{
		$countPosts = IpqaCategoryTbl::find()
		->where(['category' => $category])
		->count();

		$posts = IpqaCategoryTbl::find()
		->where(['category' => $category])
		->orderBy('order_no, problem')
		->all();

		if($countPosts>0){
			foreach($posts as $post){
				echo "<option value='".$post->problem."'>".$post->problem."</option>";
			}
		}
		else{
			echo "<option>-</option>";
		}

	}
}
