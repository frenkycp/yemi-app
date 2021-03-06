<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\search\ProdNgDataSearch;
use app\models\ProdNgData;
use app\models\NgSmtModel;
use app\models\ProdNgCategory;
use app\models\SernoMaster;
use app\models\Karyawan;
use app\models\SkillMaster;
use app\models\SkillMasterKaryawan;
use app\models\SkillMasterKaryawanLog;

class NgSmtController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex($value='')
	{
		$searchModel  = new ProdNgDataSearch;
		$searchModel->loc_id = 'WM03';
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
		$model = new NgSmtModel;
		$model->post_date = date('Y-m-d');
		$model->loc_id = 'WM03';

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
        			// $tmp_log = SkillMasterKaryawanLog::find()->where(['NIK' => $model_action->nik, 'skill_id' => $tmp_skill])->one();
        			// if ($tmp_log->SEQ != null) {
        			// 	$tmp_arr[] = [
        			// 		'nik' => $nik,
        			// 		'skill_id' => $tmp_skill,
        			// 		'skill_value' => $value,
        			// 		'category' => 'RE-TRAINING',
        			// 		'document_no' => $model->document_no,
        			// 		'note' => $model->ng_detail,
        			// 		'user_id' => $user_id,
        			// 		'user_desc' => $user_desc,
        			// 	];
        			// } else {
        			// 	$tmp_arr[] = [
        			// 		'nik' => $nik,
        			// 		'skill_id' => $tmp_skill,
        			// 		'skill_value' => $value,
        			// 		'category' => 'TRAINING',
        			// 		'document_no' => $model->document_no,
        			// 		'note' => $model->ng_detail,
        			// 		'user_id' => $user_id,
        			// 		'user_desc' => $user_desc,
        			// 	];
        			// }
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
        			$skill_count = SkillMasterKaryawan::find()->where(['NIK' => $nik])->count();
        			if ($skill_count == 0) {
        				$sql = "{CALL SKILL_CREATE(:NIK, :USER_ID, :USER_DESC)}";
			        	$params = [
							':NIK' => $nik,
							':USER_ID' => $user_id,
							':USER_DESC' => $user_desc,
						];

						try {
						    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
						    \Yii::$app->session->setFlash("success", 'New skill master added...');
						    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
						} catch (Exception $ex) {
							\Yii::$app->session->setFlash('danger', "Error : $ex");
						}
        			}
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
		if (($model = NgSmtModel::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}