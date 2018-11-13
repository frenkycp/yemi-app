<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\search\EmpDataSearch;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use yii\web\UploadedFile;

/**
 * summary
 */
class HrgaEmpDataController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
    public function actionIndex()
	{
	    $searchModel  = new EmpDataSearch;

	    $jabatan_arr = [
    		'01-NON POSITION-KONTRAK' => 'NON POSITION KONTRAK',
    		'01-NON POSITION-TETAP' => 'NON POSITION TETAP',
    		'02-SUBLEADER' => 'SUBLEADER',
			'03-LEADER' => 'LEADER',
			'04-FOREMAN/CHIEF' => 'FOREMAN/CHIEF',
			'05-SENIOR FOREMAN/ASSISTANT MANAGER' => 'SENIOR FOREMAN/ASSISTANT MANAGER',
			'06-MANAGER' => 'MANAGER',
			'07-DEPUTY GM' => 'DEPUTY GM',
			'08-GM' => 'GM',
			'09-GM&DIRECTOR' => 'GM&DIRECTOR'
    	];
	    
	    if (\Yii::$app->request->get('period') !== null) {
	    	$searchModel->PERIOD = \Yii::$app->request->get('period');
	    }

	    if ($searchModel->PERIOD === null) {
	    	$searchModel->PERIOD = date('Ym');
	    }

	    if (\Yii::$app->request->get('tanggal') !== null) {
	    	$searchModel->TANGGAL = \Yii::$app->request->get('tanggal');
	    } else {
	    	$searchModel->AKHIR_BULAN = 'end_of_month';
	    }

	    if (\Yii::$app->request->get('jabatan') !== null) {
	    	$searchModel->JABATAN_SR_GROUP = \Yii::$app->request->get('jabatan');
	    }

	    if (\Yii::$app->request->get('category') !== null) {
	    	$searchModel->PKWT = \Yii::$app->request->get('category');
	    }

	    if (\Yii::$app->request->get('department') !== null) {
	    	$searchModel->DEPARTEMEN = \Yii::$app->request->get('department');
	    }

	    if (\Yii::$app->request->get('grade') !== null) {
	    	$searchModel->GRADE = \Yii::$app->request->get('grade');
	    }

	    if (\Yii::$app->request->get('jk') !== null) {
	    	$searchModel->JENIS_KELAMIN = \Yii::$app->request->get('jk');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'jabatan_arr' => $jabatan_arr
		]);
	}

	public function actionUploadImage($NIK, $NAMA_KARYAWAN)
	{
		$model = new \yii\base\DynamicModel([
        	'upload_file'
	    ]);
	    $model->addRule(['upload_file'], 'file');

	    if($model->load(\Yii::$app->request->post())){
	        $model->upload_file = UploadedFile::getInstance($model, 'upload_file');
	        $new_filename = $NIK . '.' . $model->upload_file->extension;

	        if ($model->validate()) {
	        	if ($model->upload_file) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/yemi_employee_img/") . $new_filename;
	        		if ($model->upload_file->saveAs($filePath)) {
	                    
	                }
	        	}
	        	return $this->redirect(Url::previous());
	        }
	    }
	    return $this->render('upload_form', [
	    	'model' => $model,
	    	'NIK' => $NIK,
	    	'NAMA_KARYAWAN' => $NAMA_KARYAWAN,
	    ]);
	}

	public function actionGetImagePreview($NIK, $NAMA_KARYAWAN)
	{
		$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $NIK . '<br/><small>' . $NAMA_KARYAWAN . '</small></h3>
		</div>
		<div class="modal-body">
		';
		$data .= Html::img('@web/uploads/yemi_employee_img/' . $NIK . '.jpg', ['width' => '100%', 'class' => 'img-thumbnail']);
		$data .= '</div>';
		return $data;
	}

}