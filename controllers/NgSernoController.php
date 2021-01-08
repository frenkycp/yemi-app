<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

use app\models\search\NgSernoSearch;
use app\models\ProdNgSernoView;
use app\models\ProdNgDetailSerno;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
* This is the class for controller "NgSernoController".
*/
class NgSernoController extends \app\controllers\base\NgSernoController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
	    $searchModel  = new NgSernoSearch;

	    if(\Yii::$app->request->get('document_no') !== null)
	    {
	    	$searchModel->document_no = \Yii::$app->request->get('document_no');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionImagePreview($before_after, $serial_no, $img_filename)
	{
		/*$data = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			
		</div>
		<div class="modal-body">
		';*/
		$data = '<div class="text-center" style="font-size: 20px; font-weight: bold;">
			Serial No. ' . $serial_no . ' (' . $before_after . ')
		</div>';
		$data .= Html::img('@web/uploads/NG_FA/' . $img_filename, ['width' => '100%', 'class' => 'img-thumbnail']);
		//$data .= '</div>';
		return $data;
	}

	public function actionUpdateImage($detail_id, $serial_no)
	{
		$model = new \yii\base\DynamicModel([
        	'upload_file_1', 'upload_file_2'
	    ]);
	    $model->addRule(['upload_file_1', 'upload_file_2'], 'file');

	    if($model->load(\Yii::$app->request->post())){
	        $model->upload_file_1 = UploadedFile::getInstance($model, 'upload_file_1');
	        $model->upload_file_2 = UploadedFile::getInstance($model, 'upload_file_2');
	        $new_filename1 = $detail_id . '_1.' . $model->upload_file_1->extension;
	        $new_filename2 = $detail_id . '_2.' . $model->upload_file_2->extension;

	        if ($model->validate()) {
	        	$new_data = ProdNgDetailSerno::find()->where(['detail_id' => $detail_id])->one();
	        	if ($model->upload_file_1) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/NG_FA/") . $new_filename1;
	        		$filePathThumbnail = \Yii::getAlias("@app/web/uploads/NG_FA/thumbnail/") . $new_filename1;
	        		if ($model->upload_file_1->saveAs($filePath)) {
	                    Image::thumbnail($filePath, 50, 50)
    					->save($filePathThumbnail, ['quality' => 80]);
    					$new_data->img_before = $new_filename1;
	                }
	        	}
	        	if ($model->upload_file_2) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/NG_FA/") . $new_filename2;
	        		$filePathThumbnail = \Yii::getAlias("@app/web/uploads/NG_FA/thumbnail/") . $new_filename2;
	        		if ($model->upload_file_2->saveAs($filePath)) {
	                    Image::thumbnail($filePath, 50, 50)
    					->save($filePathThumbnail, ['quality' => 80]);
    					$new_data->img_after = $new_filename2;
	                }
	        	}
	        	if (!$new_data->save()) {
	        		return json_encode($new_data->errors);
	        	}
	        	return $this->redirect(Url::previous());
	        }
	    }
	    return $this->render('update-image', [
	    	'model'=>$model,
	    	'serial_no' => $serial_no,
	    ]);
	}
}
