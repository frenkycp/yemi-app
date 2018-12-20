<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\GojekOrderTbl;

class GojekOrderDepartureController extends Controller
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

	    	if ($order_data->daparture_date != null) {
	    		\Yii::$app->session->setFlash('warning', "Slip Number : $slip_id has been departed at $order_data->daparture_date");
	    		return $this->render('index', [
					'model' => $model
				]);
	    	}

	        $sql = "{CALL CALL_GOJEK_DEPARTURE(:slip_id, :dep_nik)}";
	        $params = [
				':slip_id' => $slip_id,
				':dep_nik' => \Yii::$app->user->identity->username,
			];

			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
			    \Yii::$app->session->setFlash('success', "Slip Number : $slip_id has been departed.");
			} catch (Exception $ex) {
				\Yii::$app->session->setFlash('danger', "Error : $ex");
			}
	    }

		return $this->render('index', [
			'model' => $model
		]);
	}
}