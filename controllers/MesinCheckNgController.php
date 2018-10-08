<?php

namespace app\controllers;

use app\models\search\MesinCheckNgSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\MesinCheckNgDtr;
use yii\web\UploadedFile;

/**
* This is the class for controller "MesinCheckNgController".
*/
class MesinCheckNgController extends \app\controllers\base\MesinCheckNgController
{
	
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new MesinCheckNgSearch;
	    if (\Yii::$app->request->get('mesin_last_update') !== null) {
	    	$searchModel->mesin_last_update = \Yii::$app->request->get('mesin_last_update');
	    }
	    if (\Yii::$app->request->get('repair_status') !== null) {
	    	$searchModel->repair_status = \Yii::$app->request->get('repair_status');
	    }
	    if (\Yii::$app->request->get('ticket_no') !== null) {
	    	$searchModel->urutan = \Yii::$app->request->get('ticket_no');
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

	public function actionGetSparePart($mesin_id = 'MNT00481')
	{
		$sql = "{CALL SPARE_PART_STOCK(:MACHINE)}";
		// passing the params into to the sql query
		$params = [':MACHINE'=>$mesin_id];
		// execute the sql command
		$result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryAll();
		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th>Machine ID</th>
			<th>Item</th>
			<th>Item Description</th>
			<th>UM</th>
			<th>ON HAND</th>
			<th>PO</th>
			<th>IMR</th>
		</tr>'
		;
		if (count($result) > 0) {
			foreach ($result as $value) {
				$data .= '
				<tr>
					<td>' . $value['MACHINE'] . '</td>
					<td>' . $value['ITEM'] . '</td>
					<td>' . $value['ITEM_DESC'] . '</td>
					<td>' . $value['UM'] . '</td>
					<td>' . $value['ONHAND'] . '</td>
					<td>' . $value['PO'] . '</td>
					<td>' . $value['IMR'] . '</td>
				</tr>
				';
			}
		} else {
			$data .= '
			<tr>
				<td colspan="7">No Sparepart Data</td>
			</tr>
			';
		}
		
		$data .= '</table>';
		return $data;
	}

	public function actionGetImagePreview($urutan)
	{
		//return \Yii::$app->urlManager->createUrl('uploads/NG_MNT/' . $urutan . '.jpg');
		$data = '
		<div class="row">
			<div class="col-md-6">
				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Before</h3>
					</div>
					<div class="box-body">
						' . Html::img('@web/uploads/NG_MNT/' . $urutan . '_1.jpg', ['width' => '100%']) . '
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="box box-success box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">After</h3>
					</div>
					<div class="box-body">
						' . Html::img('@web/uploads/NG_MNT/' . $urutan . '_2.jpg', ['width' => '100%']) . '
					</div>
				</div>
			</div>
		</div>
		
		'
		;
		return $data;
		$src = \Yii::$app->request->BaseUrl . '/uploads/NG_MNT/' . $urutan . '.jpg';
		$src = \Yii::$app->basePath. '\uploads\NG_MNT\\' . $urutan . '.jpg';
		$src = Html::img('@web/uploads/NG_MNT/' . $urutan . '.jpg', ['width' => '100%']);
		//return $src;
		return Html::img('@web/uploads/NG_MNT/' . $urutan . '.jpg', ['width' => '100%']);
		if (@getimagesize($src)) {
			return Html::img('@web/uploads/NG_MNT/' . $urutan . '.jpg', ['width' => '100%']);
		}
		return 'No Image Found...';
	}

	public function actionUpdate($urutan)
	{
		$model = $this->findModel($urutan);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(Url::previous());
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	public function actionChangeColor($urutan)
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($urutan);

		if ($model->color_stat == 1) {
			$model->color_stat = 0;
		} else {
			$model->color_stat = 1;
		}

		if (!$model->save()) {
			return json_encode($model->errors);
		} else {
			$detail = new MesinCheckNgDtr();
			$detail->urutan = $urutan;
			$detail->color_stat = $model->color_stat;
			$detail->stat_last_update = date('Y-m-d H:i:s');
			if ($detail->save()) {
				return $this->redirect(Url::previous());
			} else {
				return json_encode($detail->errors);
			}
			
		}
	}

	public function actionUploadImage($urutan)
	{
		$model = new \yii\base\DynamicModel([
        	'upload_file_1', 'upload_file_2'
	    ]);
	    $model->addRule(['upload_file_1', 'upload_file_2'], 'file');

	    if($model->load(\Yii::$app->request->post())){
	        $model->upload_file_1 = UploadedFile::getInstance($model, 'upload_file_1');
	        $model->upload_file_2 = UploadedFile::getInstance($model, 'upload_file_2');
	        $new_filename1 = $urutan . '_1.' . $model->upload_file_1->extension;
	        $new_filename2 = $urutan . '_2.' . $model->upload_file_2->extension;

	        if ($model->validate()) {
	        	if ($model->upload_file_1) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/NG_MNT/") . $new_filename1;
	        		if ($model->upload_file_1->saveAs($filePath)) {
	                    
	                }
	        	}
	        	if ($model->upload_file_2) {
	        		$filePath = \Yii::getAlias("@app/web/uploads/NG_MNT/") . $new_filename2;
	        		if ($model->upload_file_2->saveAs($filePath)) {
	                    
	                }
	        	}
	        	return $this->redirect(Url::previous());
	        }
	    }
	    return $this->render('upload_form', [
	    	'model'=>$model,
	    	'urutan' => $urutan,
	    ]);
	}
}
