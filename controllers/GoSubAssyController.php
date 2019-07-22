<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\GoSaDriver;

class GoSubAssyController extends Controller
{
	public function actionIndex()
	{
		$nik = \Yii::$app->user->identity->username;
		$driver_data = GoSaDriver::find()->where(['GOJEK_ID' => $nik])->asArray()->one();
		return $this->render('index', [
			'driver_data' => $driver_data
		]);
	}

	public function actionStart($GOJEK_ID, $GOJEK_DESC)
	{
    	$model = GoSaDriver::find()
    	->where([
    		'GOJEK_ID' => $GOJEK_ID
    	])
    	->one();

	    try{
	    	if ($model->load(\Yii::$app->request->post())) {

	    		if ($model->next_process_id == null) {
	    			echo 'Kosong';
	    		} else {
	    			$splitter = ' - ';
	    			$next_process = $model->next_process_id;
	    			$current_data = ServerMachineIotCurrent::find()
			    	->where([
			    		'mesin_id' => $mesin_id
			    	])
			    	->one();
			    	$lot_id = $current_data->lot_number;
			    	$current_data->lot_number = null;
			    	$current_data->gmc = null;
			    	$current_data->gmc_desc = null;
			    	$current_data->lot_qty = null;

			    	//split mesin_id & mesin_description
			    	$start_index = strpos($next_process, $splitter);
			    	$length_str = strlen($next_process);
			    	$mesin_id = substr($next_process, 0, $start_index);
			    	$start_index += strlen($splitter);
			    	$mesin_description = substr($next_process, $start_index, $length_str);

			    	/**/if ($current_data->save()) {
			    		$lot_data = WipEffTbl::find()
				    	->where([
				    		'lot_id' => $lot_id,
				    	])
				    	->one();
				    	$lot_data->mesin_id = $mesin_id;
				    	$lot_data->mesin_description = $mesin_description;
				    	if (!$lot_data->save()) {
				    		return json_encode($lot_data->errors);
				    	}
			    	} else {
			    		return json_encode($current_data->errors);
			    	}
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
}