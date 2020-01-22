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
	        'countermeasure'
	    ]);
	    $model_action->addRule(['countermeasure'], 'required');
	    $model_action->countermeasure = $model->next_action;

		if ($model_action->load(\Yii::$app->request->post())) {
			$model->next_action = $model_action->countermeasure;
			
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

	protected function findModel($id)
	{
		if (($model = NgPcbModel::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}