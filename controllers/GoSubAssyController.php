<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\Karyawan;
use app\models\GojekTbl;
use app\models\GojekOrderTbl;
use yii\helpers\Url;

class GoSubAssyController extends Controller
{
	/**/public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		Url::remember();
		$nik = \Yii::$app->user->identity->username;
		$driver_data = GojekTbl::find()->where([
			'GOJEK_ID' => $nik,
			'SOURCE' => 'SUB'
		])->asArray()->one();
		$detail_data = GojekOrderTbl::find()->where([
			'source' => 'SUB',
			'GOJEK_ID' => $nik,
			'STAT' => 'O'
		])->asArray()->one();
		return $this->render('index', [
			'driver_data' => $driver_data,
			'detail_data' => $detail_data,
		]);
	}

	public function actionStart($GOJEK_ID, $GOJEK_DESC)
	{
		date_default_timezone_set('Asia/Jakarta');
    	$model = new \yii\base\DynamicModel([
	        'remark'
	        //'remark', 'requestor_nik'
	    ]);
	    $model->addRule(['remark'], 'required');
	    //$model->addRule(['remark', 'requestor_nik'], 'required');

	    try{
	    	if ($model->load(\Yii::$app->request->post())) {
	    		$tmp_driver = GojekTbl::find()
	    		->where([
	    			'GOJEK_ID' => $GOJEK_ID,
	    			'SOURCE' => 'SUB'
	    		])
	    		->one();

	    		/*$requestor = Karyawan::find()->where([
	    			'NIK' => $model->requestor_nik
	    		])->one();

	    		if ($requestor->NIK != null) {
	    			$nama_karyawan = $requestor->NAMA_KARYAWAN;
	    		} else {
	    			$nama_karyawan = 'NO NAME';
	    		}*/
	    		
	    		$count_data = GojekOrderTbl::find()->where(['source' => 'SUB'])->count();
	    		$count_data++;
	    		$slip_id = str_pad($count_data, 7, '0', STR_PAD_LEFT);

	    		$new_record = new GojekOrderTbl();
	    		$new_record->slip_id = $slip_id;
	    		$new_record->item = $slip_id;
	    		$new_record->item_desc = $model->remark;
	    		$new_record->from_loc = 'SUB ASSY';
	    		$new_record->to_loc = 'SUB ASSY';
	    		$new_record->source = 'SUB';
	    		$new_record->issued_date = date('Y-m-d H:i:s');
	    		$new_record->daparture_date = date('Y-m-d H:i:s');
	    		$new_record->GOJEK_ID = $GOJEK_ID;
	    		$new_record->GOJEK_DESC = $GOJEK_DESC;
	    		//$new_record->NIK_REQUEST = $model->requestor_nik;
	    		//$new_record->NAMA_KARYAWAN = $nama_karyawan;
	    		$new_record->STAT = 'O';
	    		$new_record->DEPARTURE_NAMA_KARYAWAN = $GOJEK_DESC;
	    		$new_record->quantity = 1;
	    		$new_record->post_date = date('Y-m-d');

	    		if ($new_record->save()) {
	    			$tmp_driver->STAGE = 'DEPARTURE';
	    			$tmp_driver->LAST_UPDATE = date('Y-m-d H:i:s');
	    			if (!$tmp_driver->save()) {
	    				return json_encode($tmp_driver->errors);
	    			} else {
	    				return $this->redirect(Url::previous());
	    			}
	    		} else {
	    			return json_encode($new_record->errors);
	    		}
	    	}
	    } catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}

    	return $this->renderAjax('start', [
    		'model' => $model
    	]);
	}

	public function actionEnd($GOJEK_ID, $GOJEK_DESC)
	{
		date_default_timezone_set('Asia/Jakarta');
		$last_update = date('Y-m-d H:i:s');
		$detail_data = GojekOrderTbl::find()
		->where([
			'GOJEK_ID' => $GOJEK_ID,
			'source' => 'SUB',
			'STAT' => 'O'
		])
		->one();
		$detail_data->arrival_date = date('Y-m-d H:i:s');
		$detail_data->STAT = 'C';
		$detail_data->ARRIVAL_KARYAWAN = $GOJEK_DESC;

		$start_date = new \DateTime($detail_data->daparture_date);
		$since_start = $start_date->diff(new \DateTime($last_update));
		$minutes = $since_start->days * 24 * 60;
		$minutes += $since_start->h * 60;
		$minutes += $since_start->i;

		$detail_data->LT = $minutes;

		if (!$detail_data->save()) {
			return json_encode($detail_data->errors);
		}

		$tmp_driver = GojekTbl::find()
		->where([
			'GOJEK_ID' => $GOJEK_ID,
			'SOURCE' => 'SUB'
		])
		->one();

		$tmp_driver->STAGE = 'ARRIVAL';
		$tmp_driver->LAST_UPDATE = $last_update;
		if (!$tmp_driver->save()) {
			return json_encode($tmp_driver->errors);
		}
		return $this->redirect(Url::previous());
	}
}