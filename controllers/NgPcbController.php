<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\ProdNgDataSearch;
use app\models\ProdNgData;
use app\models\NgPcbModel;
use app\models\ProdNgCategory;
use app\models\SernoMaster;
use app\models\Karyawan;
use app\models\SkillMaster;
use app\models\SkillMasterKaryawan;
use app\models\SkillMasterKaryawanLog;

/**
 * 
 */
class NgPcbController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex($value='')
	{
		$searchModel  = new ProdNgDataSearch;
		$searchModel->loc_id = 'WM01';
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionDetail($id)
	{
		$model = $this->findModel($id);

		$data = '<form role="form">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="model">Model</label>
						<input class="form-control" id="model" readonly="readonly" value="' . $model->gmc_no . ' | ' . $model->gmc_desc . '">
					</div>
					<div class="form-group">
						<label for="pcb">PCB</label>
						<input class="form-control" id="pcb" readonly="readonly" value="' . $model->wipName . '">
					</div>
					<div class="form-group">
						<label for="ng_found">NG Found</label>
						<input class="form-control" id="ng_found" readonly="readonly" value="' . $model->pcb_ng_found . '">
					</div>
					<div class="form-group">
						<label for="side">Side</label>
						<input class="form-control" id="side" readonly="readonly" value="' . $model->pcb_side . '">
					</div>
					<div class="form-group">
						<label for="ng_qty">NG Qty</label>
						<input class="form-control" id="ng_qty" readonly="readonly" value="' . $model->ng_qty . '">
					</div>
					<div class="form-group">
						<label for="problem">Problem</label>
						<input class="form-control" id="problem" readonly="readonly" value="' . $model->ngCategory . '">
					</div>
					<div class="form-group">
						<label for="ng_detail">NG Detail</label>
						<input class="form-control" id="ng_detail" readonly="readonly" value="' . $model->ng_detail . '">
					</div>
					<div class="form-group">
						<label for="occu">Occu</label>
						<input class="form-control" id="occu" readonly="readonly" value="' . $model->pcb_occu . '">
					</div>
					<div class="form-group">
						<label for="process">Process</label>
						<input class="form-control" id="process" readonly="readonly" value="' . $model->pcb_process . '">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="line">Line</label>
						<input class="form-control" id="line" readonly="readonly" value="' . $model->line . '">
					</div>
					<div class="form-group">
						<label for="part_section">Part Section</label>
						<input class="form-control" id="part_section" readonly="readonly" value="' . $model->pcb_part_section . '">
					</div>
					<div class="form-group">
						<label for="part_name">Part Name</label>
						<input class="form-control" id="part_name" readonly="readonly" value="' . $model->part_desc . '">
					</div>
					<div class="form-group">
						<label for="location">Location</label>
						<input class="form-control" id="location" readonly="readonly" value="' . $model->ng_location . '">
					</div>
					<div class="form-group">
						<label for="detected">Detected</label>
						<input class="form-control" id="detected" readonly="readonly" value="' . $model->detected_by_id . '">
					</div>
					<div class="form-group">
						<label for="repair">Repair</label>
						<input class="form-control" id="repair" readonly="readonly" value="' . $model->pcb_repair . '">
					</div>
					<div class="form-group">
						<label for="root_cause_category">Root Cause Category</label>
						<input class="form-control" id="root_cause_category" readonly="readonly" value="' . $model->ng_cause_category . '">
					</div>
					<div class="form-group">
						<label for="pic_ng">PIC (NG)</label>
						<input class="form-control" id="pic_ng" readonly="readonly" value="' . $model->empDesc . '">
					</div>
				</div>
			</div>
		</form>';

		return $data;
	}

	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new NgPcbModel;
		$model->post_date = date('Y-m-d');
		$model->loc_id = 'WM01';

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
		return $this->render('create', ['model' => $model]);
	}

	public function actionUpdate($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);
		if ($model->part_no != null) {
			$model->part_desc = $model->part_no . ' | ' . $model->part_desc;
		}
		$model->pcb_id = $model->pcb_id . ' | ' . $model->pcb_name;

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionNextAction($id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($id);

		$model_action = new \yii\base\DynamicModel([
	        'countermeasure', 'remark'
	    ]);
	    $model_action->addRule(['countermeasure'], 'required');
	    $model_action->countermeasure = $model->next_action;
	    $model_action->remark = $model->action_remark;

		if ($model_action->load(\Yii::$app->request->post())) {
			$model->next_action = $model_action->countermeasure;
			$model->action_remark = $model_action->remark;
			
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
		} else {
			return $this->renderAjax('next-action', [
				'model' => $model,
				'model_action' => $model_action,
			]);
		}
	}

		public function actionGetSkillValue($nik, $skill_id)
	{
		$tmp_skill_master = SkillMasterKaryawan::find()->where(['NIK' => $nik, 'skill_id' => $skill_id])->one();
		return $tmp_skill_master->skill_value;
	}

	public function actionCountermeasure($id = null, $nik = null)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = null;
		if ($id != null) {
			$model = $this->findModel($id);
			$nik = $model->emp_id;
		}
		

		$model_action = new \yii\base\DynamicModel([
	        'action', 'remark', 'skill_name', 'skill_value', 'nik'
	    ]);
	    $model_action->addRule(['action'], 'required');
	    $model_action->addRule(['skill_name', 'nik', 'remark'], 'string');
	    $model_action->addRule(['skill_value'], 'number');
	    $model_action->nik = $nik;

	    $tmp_arr1 = ArrayHelper::map(SernoMaster::find()->select(['gmc', 'model', 'color', 'dest'])->all(), 'gmc', 'fullDescription');
        $tmp_arr2 = ArrayHelper::map(SkillMaster::find()->select(['skill_id', 'skill_desc'])->where(['<>', 'skill_group', 'Z'])->all(), 'skill_id', 'description');
        $skill_dropdown_arr = array_merge($tmp_arr2, $tmp_arr1);

        if ($model_action->load(\Yii::$app->request->post())) {
        	$user_id = \Yii::$app->user->identity->username;

        	$creator = Karyawan::find()->where([
			   	'OR',
			   	['NIK' => $user_id],
				['NIK_SUN_FISH' => $user_id]
			])->one();
			$user_id = $creator->NIK_SUN_FISH;
			$user_desc = $creator->NAMA_KARYAWAN;

        	$count = 0;
        	$tmp_arr = [];
        	foreach ($model_action->skill_value as $key => $value) {
        		$tmp_skill = $model_action->skill_name[$key];
        		if ($value != '' && $tmp_skill != '') {
        			$tmp_log = SkillMasterKaryawanLog::find()->where(['NIK' => $model_action->nik, 'skill_id' => $tmp_skill])->one();
        			if ($tmp_log->SEQ != null) {
        				$tmp_arr[] = [
        					'nik' => $nik,
        					'skill_id' => $tmp_skill,
        					'skill_value' => $value,
        					'category' => 'RE-TRAINING',
        					'document_no' => $model->document_no,
        					'note' => $model->ng_detail,
        					'user_id' => $user_id,
        					'user_desc' => $user_desc,
        				];
        			} else {
        				$tmp_arr[] = [
        					'nik' => $nik,
        					'skill_id' => $tmp_skill,
        					'skill_value' => $value,
        					'category' => 'TRAINING',
        					'document_no' => $model->document_no,
        					'note' => $model->ng_detail,
        					'user_id' => $user_id,
        					'user_desc' => $user_desc,
        				];
        			}
        			$count++;
        		}
        	}
        	if ($model_action->action == 'TRAINING') {
        		if ($count == 0) {
        			\Yii::$app->session->setFlash("warning", "Please input at least 1 skill update. (eg. Finish Product Number -> " . $model->gmc_no . ")");
	        		return $this->render('countermeasure', [
						'model' => $model,
						'model_action' => $model_action,
						'skill_dropdown_arr' => $skill_dropdown_arr,
					]);
        		} else {
        			foreach ($tmp_arr as $key => $value) {
        				$sql = "{CALL SKILL_UPDATE_NEW(:NIK, :skill_id, :skill_value, :category, :document_no, :NOTE, :USER_ID, :USER_DESC)}";
			        	$params = [
							':NIK' => $value['nik'],
							':skill_id' => $value['skill_id'],
							':skill_value' => $value['skill_value'],
							':category' => $value['category'],
							':document_no' => $value['document_no'],
							':NOTE' => $value['note'],
							':USER_ID' => $value['user_id'],
							':USER_DESC' => $value['user_desc'],
						];

						try {
						    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
						    \Yii::$app->session->setFlash("success", 'Training action completed...');
						    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
						} catch (Exception $ex) {
							\Yii::$app->session->setFlash('danger', "Error : $ex");
						}
        			}
        			
        		}
        	}
        	$model->next_action = $model_action->action;
			$model->action_remark = $model_action->remark;
			
			if (!$model->save()) {
				return json_encode($model->errors);
			}
			
			return $this->redirect(Url::previous());
        }

		return $this->render('countermeasure', [
			'model' => $model,
			'model_action' => $model_action,
			'skill_dropdown_arr' => $skill_dropdown_arr,
		]);
	}

	protected function findModel($id)
	{
		if (($model = NgPcbModel::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}