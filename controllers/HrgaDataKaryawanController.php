<?php

namespace app\controllers;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use dmstr\bootstrap\Tabs;

use app\models\Karyawan;
use app\models\search\HrgaDataKaryawanSearch;
use yii\web\UploadedFile;

/**
* This is the class for controller "HrgaDataKaryawanController".
*/
class HrgaDataKaryawanController extends \app\controllers\base\HrgaDataKaryawanController
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	/**
	* Lists all Karyawan models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new HrgaDataKaryawanSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$departemen_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(DEPARTEMEN)')->where('DEPARTEMEN IS NOT NULL')->orderBy('DEPARTEMEN')->all(), 'DEPARTEMEN', 'DEPARTEMEN');
		$section_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(SECTION)')->where('SECTION IS NOT NULL')->orderBy('SECTION')->all(), 'SECTION', 'SECTION');
		$sub_section_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(SUB_SECTION)')->where('SUB_SECTION IS NOT NULL')->orderBy('SUB_SECTION')->all(), 'SUB_SECTION', 'SUB_SECTION');
		$status_karyawan_dropdown = ArrayHelper::map(Karyawan::find()->select('DISTINCT(STATUS_KARYAWAN)')->orderBy('STATUS_KARYAWAN')->all(), 'STATUS_KARYAWAN', 'STATUS_KARYAWAN');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'departemen_dropdown' => $departemen_dropdown,
		    'section_dropdown' => $section_dropdown,
		    'sub_section_dropdown' => $sub_section_dropdown,
		    'status_karyawan_dropdown' => $status_karyawan_dropdown,
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
