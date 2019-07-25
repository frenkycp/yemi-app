<?php

namespace app\controllers;

use app\models\GoSaTbl;
use app\models\GojekOrderTbl;
use yii\helpers\Url;

/**
* This is the class for controller "GoSaTblController".
*/
class GoSaTblController extends \app\controllers\base\GoSaTblController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	/**
	* Creates a new GoSaTbl model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new \yii\base\DynamicModel([
	        'REQUESTOR_NIK', 'REQUESTOR_NAME', 'REMARK', 'EMP'
	    ]);
	    $model->addRule(['REQUESTOR_NIK', 'REQUESTOR_NAME', 'REMARK', 'EMP'], 'required');
	    $model->REQUESTOR_NIK = \Yii::$app->user->identity->username;
		$model->REQUESTOR_NAME = \Yii::$app->user->identity->name;

		try {
			if ($model->load($_POST)) {
				$columnNameArray=['slip_id', 'item', 'item_desc', 'from_loc', 'to_loc', 'source', 'issued_date', 'GOJEK_ID', 'GOJEK_DESC', 'STAT', 'quantity', 'post_date', 'session_id', 'NIK_REQUEST', 'NAMA_KARYAWAN'];
				$count_data = GojekOrderTbl::find()->where(['source' => 'SUB'])->count();

				$total_mp = 0;

				$sa_tbl = new GoSaTbl;
				$sa_tbl->REQUESTOR_NIK = $model->REQUESTOR_NIK;
				$sa_tbl->REQUESTOR_NAME = $model->REQUESTOR_NAME;
				$sa_tbl->REMARK = $model->REMARK;
				$sa_tbl->TOTAL_MP = count($model->EMP);

				if (!$sa_tbl->save()) {
					return json_encode($sa_tbl->errors);
				}

				$tmp_insert = [];
				foreach ($model->EMP as $key => $value) {
					$emp_split = explode(' - ', $value);
					$total_mp++;
					$count_data++;
    				$slip_id = str_pad($count_data, 7, '0', STR_PAD_LEFT);
					$tmp_insert[] = [
						$slip_id,
						$slip_id,
						$model->REMARK,
						'SUB ASSY',
						'SUB ASSY',
						'SUB',
						date('Y-m-d H:i:s'),
						$emp_split[0],
						$emp_split[1],
						'O',
						1,
						date('Y-m-d'),
						$sa_tbl->ID,
						$model->REQUESTOR_NIK,
						$model->REQUESTOR_NAME
					];
				}

				$insertCount = \Yii::$app->db_sql_server->createCommand()->batchInsert('db_owner.GOJEK_ORDER_TBL', $columnNameArray, $tmp_insert)->execute();
				
				return $this->redirect(Url::previous());
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', ['model' => $model]);
	}
}
