<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\ServerMachineIotCurrent;
use app\models\WipEffTbl;
use yii\helpers\Url;

class ServerMntMachineCurrentController extends Controller
{
	public function actionIndex()
	{
		$this->layout = 'clean';
		Url::remember();
		$mesin_id = '';
        date_default_timezone_set('Asia/Jakarta');
        $data = $lot_data = null;
        $mesin_description = '';
        //$current_data = [];

        if (\Yii::$app->request->get('mesin_id') !== '') {
        	$mesin_id = \Yii::$app->request->get('mesin_id');
        	$tmp_data = ServerMachineIotCurrent::find()
        	->where([
        		'mesin_id' => $mesin_id
        	])
        	->one();
        	$current_data = [
        		'lot_id' => $tmp_data->lot_number,
        		'gmc' => $tmp_data->gmc,
        		'gmc_desc' => $tmp_data->gmc_desc,
        		'lot_qty' => $tmp_data->lot_qty
        	];
        	$mesin_description = $mesin_id . ' - ' . $tmp_data->mesin_description;
        	$lot_data = WipEffTbl::find()
        	->where([
        		'child_analyst' => 'WW02',
        		'plan_stats' => 'O',
        		'jenis_mesin' => $tmp_data->kelompok
        	])
        	->asArray()
        	->all();
        }

		return $this->render('index', [
			'data' => $data,
			'current_data' => $current_data,
			'lot_data' => $lot_data,
			'mesin_description' => $mesin_description,
			'mesin_id' => $mesin_id,
		]);
	}

	public function actionStartMachine($mesin_id='', $lot_id = '')
	{
		date_default_timezone_set('Asia/Jakarta');
		$lot_data = WipEffTbl::find()
    	->where([
    		'lot_id' => $lot_id,
    	])
    	->one();

    	$current_data = ServerMachineIotCurrent::find()
    	->where([
    		'mesin_id' => $mesin_id
    	])
    	->one();

    	$lot_data->mesin_id = $current_data->mesin_id;
    	$lot_data->mesin_description = $current_data->mesin_description;
    	$lot_data->plan_run = 'R';
    	if ($lot_data->start_date == null) {
    		$lot_data->start_date = date('Y-m-d H:i:s');
    	}
    	if (!$lot_data->save()) {
    		return json_encode($lot_data->errors);
    	}

    	$current_data->lot_number = $lot_id;
    	$current_data->gmc = $lot_data->child_all;
    	$current_data->gmc_desc = $lot_data->child_desc_all;
    	$current_data->lot_qty = $lot_data->qty_all;
    	if ($current_data->save()) {
    		return $this->redirect(Url::previous());
    	} else {
    		return json_encode($current_data->errors);
    	}
    	
	}

	public function actionFinish($mesin_id)
	{
		date_default_timezone_set('Asia/Jakarta');
    	$model = new \yii\base\DynamicModel([
	        'next_process_id'
	    ]);
	    $model->addRule('next_process_id', 'string');

	    try{
	    	if ($model->load(\Yii::$app->request->post())) {
	    		$next_process = $model->next_process_id;

	    		$current_data = ServerMachineIotCurrent::find()
		    	->where([
		    		'mesin_id' => $mesin_id
		    	])
		    	->one();
		    	$lot_id = $current_data->lot_number;

		    	$lot_data = WipEffTbl::find()
		    	->where([
		    		'lot_id' => $lot_id,
		    	])
		    	->one();
		    	$lot_data->mesin_id = null;
		    	$lot_data->mesin_description = null;

		    	$current_data->lot_number = null;
		    	$current_data->gmc = null;
		    	$current_data->gmc_desc = null;
		    	$current_data->lot_qty = null;

	    		if ($model->next_process_id == null) {
	    			$lot_data->end_date = date('Y-m-d H:i:s');
	    			$lot_data->plan_run = 'E';
	    			$lot_data->plan_stats = 'C';
	    		}

	    		if ($current_data->save()) {
			    	$lot_data->jenis_mesin = $next_process;
			    	if (!$lot_data->save()) {
			    		return json_encode($lot_data->errors);
			    	}
		    	} else {
		    		return json_encode($current_data->errors);
		    	}
	    		return $this->redirect(Url::previous());
	    	}
	    } catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}

    	return $this->renderAjax('finish', [
    		'model' => $model
    	]);
	}
}