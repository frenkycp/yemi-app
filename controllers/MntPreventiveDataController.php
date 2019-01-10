<?php

namespace app\controllers;

use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\search\PreventiveDataSearch;
use app\models\MesinCheckTbl;
use yii\web\UploadedFile;
use yii\web\Controller;
use app\models\MachineMpPlanViewMaster02;

/**
* This is the class for controller "MesinCheckDtrController".
*/
class MntPreventiveDataController extends Controller
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new PreventiveDataSearch;
	    if (\Yii::$app->request->get('master_plan_maintenance') !== null) {
	    	$searchModel->master_plan_maintenance = \Yii::$app->request->get('master_plan_maintenance');
	    }
	    if (\Yii::$app->request->get('status') !== null) {
	    	$searchModel->count_close = \Yii::$app->request->get('status');
	    }
	    $dataProvider = $searchModel->search($_GET);

	    $machine_periode_arr = ArrayHelper::map(MachineMpPlanViewMaster02::find()->select('DISTINCT(mesin_periode)')->orderBy('mesin_periode ASC')->all(), 'mesin_periode', 'mesin_periode');

	    $loc_arr = ArrayHelper::map(MachineMpPlanViewMaster02::find()->select('DISTINCT(location)')->where(['<>', 'location', ''])->orderBy('location ASC')->all(), 'location', 'location');

	    $area_arr = ArrayHelper::map(MachineMpPlanViewMaster02::find()->select('DISTINCT(area)')->orderBy('area ASC')->all(), 'area', 'area');

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'machine_periode_arr' => $machine_periode_arr,
		    'loc_arr' => $loc_arr,
		    'area_arr' => $area_arr,
		]);
	}

	public function actionGetCheckSheet($mesin_id, $mesin_periode)
	{
		$check_sheet = MesinCheckTbl::find()->where(['mesin_id' => $mesin_id, 'mesin_periode' => $mesin_periode])->all();

		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= '
		<tr>
			<th>Machine ID</th>
			<th style="width:100px;">Periode</th>
			<th>Machine Name</th>
			<th>No</th>
			<th>Machine Part</th>
			<th>Check Remark</th>
		</tr>
		';

		foreach ($check_sheet as $value) {
			$data .= '
			<tr>
				<td>' . $value->mesin_id . '</td>
				<td>' . $value->mesin_periode . '</td>
				<td>' . $value->mesin_nama . '</td>
				<td>' . $value->mesin_no . '</td>
				<td>' . $value->mesin_bagian . '</td>
				<td>' . $value->mesin_bagian_ket . '</td>
			</tr>
			';
		}

		$data .= '</table>';

		return $data;
	}

	public function actionUploadImage($mesin_id)
	{
		$model = new \yii\base\DynamicModel([
        	'upload_file'
	    ]);
	    $model->addRule(['upload_file'], 'file');

	    if($model->load(\Yii::$app->request->post())){
	        $model->upload_file = UploadedFile::getInstance($model, 'upload_file');
	        $new_filename = $mesin_id . '.' . $model->upload_file->extension;

	        if ($model->validate()) {
	        	if ($model->upload_file) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/MNT_MACHINE/") . $new_filename;
	        		if ($model->upload_file->saveAs($filePath)) {
	                    
	                }
	        	}
	        	return $this->redirect(Url::previous());
	        }
	    }
	    return $this->render('upload_form', [
	    	'model'=>$model,
	    	'mesin_id' => $mesin_id,
	    ]);
	}

	public function actionGetImagePreview($mesin_id, $machine_desc)
	{
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $mesin_id . '<br/><small>' . $machine_desc . '</small></h3>
		</div>
		<div class="modal-body">
		';
		$data .= Html::img('@web/uploads/MNT_MACHINE/' . $mesin_id . '.jpg', ['width' => '100%', 'class' => 'img-thumbnail']);
		$data .= '</div>';
		return $data;
	}

	public function actionGetEvidencePreview($mesin_id, $machine_desc, $masterplan)
	{
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $mesin_id . '<br/><small>' . $machine_desc . ' >>> Preventive on ' . $masterplan . '</small></h3>
		</div>
		<div class="modal-body">
		';
		$data .= Html::img('@web/uploads/MNT_PREVENTIVE/' . $mesin_id . '_' . $masterplan . '.jpg', ['width' => '100%', 'class' => 'img-thumbnail']);
		$data .= '</div>';
		return $data;
	}

	/*public function actionGetHistory($mesin_id, $mesin_periode)
	{
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= '
		<tr>
			<th>Machine ID</th>
			<th>Machine Name</th>
			<th style="width:100px;">Periode</th>
			<th>Location</th>
			<th>Area</th>
			<th>Last Check</th>
		</tr>
		';

		$history = MasterplanHistory::find()->where(['mesin_id' => $mesin_id, 'mesin_periode' => $mesin_periode])->all();

		foreach ($history as $value) {
			$data .= '
			<tr>
				<td>' . $value->mesin_id . '</td>
				<td>' . $value->mesin_nama . '</td>
				<td>' . $value->mesin_periode . '</td>
				<td>' . $value->location . '</td>
				<td>' . $value->area . '</td>
				<td>' . date('d-M-Y H:i:s', strtotime($value->mesin_last_update)) . '</td>
			</tr>
			';
		}

		return $data;
	}*/
}
