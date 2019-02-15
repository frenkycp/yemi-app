<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\GojekOrderTbl;
use app\models\WipPlanActualReport;

class GojekOrderArrivalController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$model = new \yii\base\DynamicModel([
	        'slip_id'
	    ]);
	    $model->addRule(['slip_id'], 'required')
	    ->addRule('slip_id', 'string', ['max' => 10]);

	    if($model->load(\Yii::$app->request->post())){
	    	$slip_id = $model->slip_id;
	    	$model->slip_id = null;

	    	$order_data = GojekOrderTbl::find()
	    	->where([
	    		'slip_id' => $slip_id,
	    		'source' => 'WIP'
	    	])
	    	->one();

	    	if ($order_data->slip_id == null) {
	    		$tmp_wip_data = WipPlanActualReport::find()
	    		->where([
	    			'slip_id' => $slip_id
	    		])
	    		->one();

	    		if ($tmp_wip_data->slip_id == null) {
	    			\Yii::$app->session->setFlash('danger', "Process Failed...! Slip number : <b>$slip_id</b> not found!");
	    			return $this->render('index', [
						'model' => $model
					]);
	    		}
	    		
	    		\Yii::$app->session->setFlash('danger', "Process Failed...! There is no order for slip number : <b>$slip_id</b> ! Please follow the procedure ! (Slip status : <b>$tmp_wip_data->stage</b>)");
	    		return $this->render('index', [
					'model' => $model
				]);
	    	}

	    	if ($order_data->arrival_date != null) {
	    		\Yii::$app->session->setFlash('warning', "Process Failed...! Slip Number : $slip_id has been arrived at $order_data->arrival_date by $order_data->DEPARTURE_NAMA_KARYAWAN");
	    		return $this->render('index', [
					'model' => $model
				]);
	    	}

	        $sql = "{CALL CALL_GOJEK_ARRIVAL(:slip_id, :dep_nik)}";
	        $params = [
				':slip_id' => $slip_id,
				':dep_nik' => \Yii::$app->user->identity->username,
			];

			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
			    \Yii::$app->session->setFlash('success', "Slip Number : $slip_id has been arrived.");
			} catch (Exception $ex) {
				\Yii::$app->session->setFlash('danger', "Error : $ex");
			}
	    }

		return $this->render('index', [
			'model' => $model
		]);
	}
}