<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\GoSaTbl;
use app\models\GojekOrderTbl;
use app\models\GojekTbl;
use app\models\GeneralFunction;

class GoSubStartEndController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex($value='')
	{
		Url::remember();
		$data_table = GoSaTbl::find()->where(['<>', 'STATUS', 2])->asArray()->all();
		return $this->render('index', [
			'data_table' => $data_table
		]);
	}

	public function actionStart($session_id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$now = date('Y-m-d H:i:s');
		$tmp_data_start = GojekOrderTbl::find()->where(['session_id' => $session_id, 'source' => 'SUB'])->all();
		foreach ($tmp_data_start as $key => $value) {
			$sql = "{CALL CALL_GOJEK_DEPARTURE(:slip_id, :dep_nik)}";
	        $params = [
				':slip_id' => $value->slip_id,
				':dep_nik' => $value->GOJEK_ID,
			];

			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
			    //\Yii::$app->session->setFlash('success', "Slip Number : $value->slip_id has been departed.");
			} catch (Exception $ex) {
				\Yii::$app->session->setFlash('danger', "Error : $ex");
			}
			/*$update_model = GojekOrderTbl::find()->where(['id' => $value->id])->one();
			$update_model->daparture_date = $now;
			$update_model->DEPARTURE_NAMA_KARYAWAN = $value->GOJEK_DESC;
			if (!$update_model->save()) {
				return json_encode($update_model->errors);
			}

			$tmp_driver = GojekTbl::find()->where(['GOJEK_ID' => $value->GOJEK_ID, 'SOURCE' => 'SUB'])->one();
			$tmp_driver->STAGE = 'DEPARTURE';
			$tmp_driver->LAST_UPDATE = $now;
			if (!$tmp_driver->save()) {
				return json_encode($tmp_driver->errors);
			}*/
		}
		$tmp_go_sub = GoSaTbl::find()->where(['ID' => $session_id])->one();
		$tmp_go_sub->START_TIME = $now;
		$tmp_go_sub->STATUS = 1;
		if (!$tmp_go_sub->save()) {
			return json_encode($tmp_go_sub->errors);
		}

		return $this->redirect(Url::previous());
	}

	public function actionEnd($session_id)
	{
		date_default_timezone_set('Asia/Jakarta');
		$now = date('Y-m-d H:i:s');
		$tmp_data_start = GojekOrderTbl::find()->where(['session_id' => $session_id, 'source' => 'SUB'])->all();
		$lt = 0;
		foreach ($tmp_data_start as $key => $value) {
			$sql = "{CALL CALL_GOJEK_ARRIVAL(:slip_id, :dep_nik)}";
	        $params = [
				':slip_id' => $slip_id,
				':dep_nik' => \Yii::$app->user->identity->username,
			];

			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
			    //\Yii::$app->session->setFlash('success', "Slip Number : $slip_id has been arrived.");
			} catch (Exception $ex) {
				\Yii::$app->session->setFlash('danger', "Error : $ex");
			}

			/*$update_model = GojekOrderTbl::find()->where(['id' => $value->id])->one();
			$update_model->arrival_date = $now;
			$update_model->ARRIVAL_KARYAWAN = $value->GOJEK_DESC;
			$update_model->STAT = 'C';

			$lt = GeneralFunction::instance()->getWorkingTime($update_model->daparture_date, $now);
			$update_model->LT = $lt;
			
			if (!$update_model->save()) {
				return json_encode($update_model->errors);
			}

			$tmp_driver = GojekTbl::find()->where(['GOJEK_ID' => $value->GOJEK_ID, 'SOURCE' => 'SUB'])->one();
			$tmp_driver->STAGE = 'ARRIVAL';
			$tmp_driver->LAST_UPDATE = $now;
			if (!$tmp_driver->save()) {
				return json_encode($tmp_driver->errors);
			}*/
		}
		$tmp_go_sub = GoSaTbl::find()->where(['ID' => $session_id])->one();
		$tmp_go_sub->END_TIME = $now;
		$tmp_go_sub->STATUS = 2;
		$tmp_go_sub->LT = $lt;
		if (!$tmp_go_sub->save()) {
			return json_encode($tmp_go_sub->errors);
		}

		return $this->redirect(Url::previous());
	}

}