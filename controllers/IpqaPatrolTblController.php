<?php

namespace app\controllers;

use app\models\IpqaPatrolTbl;
use app\models\IpqaCategoryTbl;
use app\models\IpqaRejectHistory;
use app\models\SernoMaster;
use app\models\ImageFile;
use app\models\CostCenter;
use app\models\WipProductView;
use app\models\search\IpqaPatrolTblSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\httpclient\Client;

class IpqaPatrolTblController extends \app\controllers\base\IpqaPatrolTblController
{
	/**/public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    /**
	* Lists all IpqaPatrolTbl models.
	* @return mixed
	*/

	/*public function actionGenerateCaseNo()
	{
		$data_arr = IpqaPatrolTbl::find()->all();
		$total_case = 1;
		foreach ($data_arr as $key => $value) {
			$tmp_data = IpqaPatrolTbl::find()->where(['id' => $value->id])->one();
			$tmp_data->case_no = 'QA-P-' . str_pad($total_case, 6, '0', STR_PAD_LEFT);
			$tmp_data->save();
			$total_case++;
		}
	}*/

	public function actionIndex()
	{
	    $searchModel  = new IpqaPatrolTblSearch;
	    if (\Yii::$app->request->get('status') !== null) {
	    	$searchModel->status = \Yii::$app->request->get('status');
	    }
	    if (\Yii::$app->request->get('CC_ID') !== null) {
	    	$searchModel->CC_ID = \Yii::$app->request->get('CC_ID');
	    }
	    if (\Yii::$app->request->get('due_date') !== null) {
	    	$searchModel->due_date = \Yii::$app->request->get('due_date');
	    }
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		if (\Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $id = \Yii::$app->request->post('editableKey');
            $model = IpqaPatrolTbl::findOne(['id' => $id]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=> '' , 'message' => '']);

            $posted = current($_POST['IpqaPatrolTbl']);
            $post = ['IpqaPatrolTbl' => $posted];

            if ($model->load($post)) {
                $model->save();
                if ($model->rank_category == 'S' || $model->rank_category == 'A') {
                	$client = new \mongosoft\soapclient\Client([
					    'url' => 'http://172.17.144.211/WebService01.asmx?WSDL',
					]);
					$client->IPQA_Patrol_Rank_S(['id' => $id]);
                }
            }
            
            echo $out;
            return;
        }

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'section_arr' => $this->getSectionArr(),
		]);
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
				$total_case = IpqaPatrolTbl::find()->count();
				$total_case++;
				$case_number = 'QA-P-' . str_pad($total_case, 6, '0', STR_PAD_LEFT);
				$model->case_no = $case_number;
				//$section = CostCenter::find()->where(['CC_ID' => $model->CC_ID])->one();
				//$model->CC_ID = $section->CC_ID;
				//$model->CC_GROUP = $section->CC_GROUP;
				//$model->CC_DESC = $section->CC_DESC;

				//upload file
				$model->upload_file1 = UploadedFile::getInstance($model, 'upload_file1');
				if ($model->validate()) {
					if ($model->upload_file1) {
						$new_filename1 = 'IPQA_PATROL_' . date('Ymd_His') . '.' . $model->upload_file1->extension;
						$model->filename1 = $new_filename1;
		        		$filePath = \Yii::getAlias("@app/web/uploads/IPQA_PATROL/") . $new_filename1;
		        		if (!$model->upload_file1->saveAs($filePath)) {
		                    return json_encode($model->errors);
		                }
		                ImageFile::resize_crop_image($filePath, $filePath, 50, 800);
		        	}
				} else {
					return json_encode($model->errors);
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
			'section_arr' => $this->getSectionArr(),
		]);
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
			//$section = CostCenter::find()->where(['CC_ID' => $model->CC_ID])->one();
			//$model->CC_ID = $section->CC_ID;
			//$model->CC_GROUP = $section->CC_GROUP;
			//$model->CC_DESC = $section->CC_DESC;

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
				'section_arr' => $this->getSectionArr()
			]);
		}
	}

	/**
	* Deletes an existing IpqaPatrolTbl model.
	* If deletion is successful, the browser will be redirected to the 'index' page.
	* @param integer $id
	* @return mixed
	*/
	public function actionDelete($id)
	{
		date_default_timezone_set('Asia/Jakarta');

		try {
			$model = $this->findModel($id);
			$model->flag = 0;
			$model->delete_datetime = date('Y-m-d H:i:s');
			$model->deleted_by_id = \Yii::$app->user->identity->username;
			$model->deleted_by_name = \Yii::$app->user->identity->name;
			if (!$model->save()) {
				return json_encode($model->errors);
			} else {
				return $this->redirect(Url::previous());
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
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
			if ($model->reply_datetime == null) {
				$model->reply_datetime = date('Y-m-d H:i:s');
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
			return $this->render('reply', [
				'model' => $model,
				'model_reply' => $model_reply,
			]);
		}
	}

	public function actionClose($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		$model->status = 1;
		$model->close_datetime = date('Y-m-d H:i:s');
		$model->closed_by_id = \Yii::$app->user->identity->username;
		$model->closed_by_name = \Yii::$app->user->identity->name;

		if (!$model->save()) {
			return json_encode($model->errors);
		}
		
		return $this->redirect(Url::previous());
	}

	public function actionGmcInfo($gmc)
	{
		$speaker_model = SernoMaster::findOne(['gmc' => $gmc]);
		return $speaker_model->model . '||' . $speaker_model->color . '||' . $speaker_model->dest;
	}

	public function actionGetDesc($child)
	{
		$product = WipProductView::findOne(['child' => $child]);
		return $product->child_desc . '||' . $product->child_analyst . '||' . $product->child_analyst_desc;
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

	public function actionReject($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		$model->reject_remark = null;

		if ($model->load(\Yii::$app->request->post())) {
			$model->status = 3;
			$model->reject_answer = null;
			if ($model->save()) {
				$model_history = new IpqaRejectHistory();
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

	public function actionAnswer($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		if ($model->load(\Yii::$app->request->post())) {
			$model->status = 2;
			if ($model->save()) {
				$model_history = IpqaRejectHistory::find()
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
}
