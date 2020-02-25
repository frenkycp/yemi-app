<?php

namespace app\controllers;

use app\models\AssetTbl;
use app\models\AssetLogTbl;
use app\models\AssetStockTakeSchedule;
use app\models\Karyawan;
use yii\helpers\Url;

class AssetStockTakeScheduleController extends \app\controllers\base\AssetStockTakeScheduleController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new AssetStockTakeSchedule;

		try {
			if ($model->load($_POST)) {
				$creator = Karyawan::find()->where([
	        		'OR',
	        		['NIK' => \Yii::$app->user->identity->username],
	        		['NIK_SUN_FISH' => \Yii::$app->user->identity->username]
	        	])->one();

	        	if ($creator->NIK_SUN_FISH != null) {
	        		$tmp_asset = AssetTbl::find()->where([
		        		'FINANCE_ASSET' => 'Y',
		        		'Discontinue' => 'N'
		        	])->all();
		        	$total_open = count($tmp_asset);
		        	$model->create_by_id = $creator->NIK_SUN_FISH;
		        	$model->create_by_name = $creator->NAMA_KARYAWAN;
		        	$model->create_time = date('Y-m-d H:i:s');
		        	$model->total_open = $total_open;
		        	$model->total_close = 0;

		        	if (!$model->save()) {
						return json_encode($model->errors);
					}

		        	$bulkInsertArray = array();
		        	$columnNameArray = ['schedule_id', 'schedule_start', 'schedule_end', 'trans_type', 'asset_id', 'computer_name', 'schedule_status', 'is_scheduled', 'from_loc', 'propose_scrap'];
		        	$total_count = 0;
		        	foreach ($tmp_asset as $key => $value) {
		        		$bulkInsertArray[] = [
			    			$model->schedule_id, $model->start_date, $model->end_date, 'PI', $value->asset_id, $value->computer_name, 'O', 'Y', $value->location, null
			    		];
			    		if((count($bulkInsertArray) % 500) == 0){
			        		$insertCount = \Yii::$app->db_sql_server->createCommand()
			        		->batchInsert(AssetLogTbl::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
			        		->execute();
			        		$bulkInsertArray = array();
			        		$total_count += $insertCount;
			        	}
		        	}
					
					if(count($bulkInsertArray) > 0){
		        		$insertCount = \Yii::$app->db_sql_server->createCommand()
		        		->batchInsert(AssetLogTbl::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
		        		->execute();
		        		$total_count += $insertCount;
		        	}
		        	\Yii::$app->getSession()->addFlash('success', number_format($total_count) . ' data inserted...');
					return $this->redirect(Url::previous());
	        	} else {
	        		\Yii::$app->getSession()->addFlash('warning', 'You\'re using unregistered user...');
	        		return $this->render('create', ['model' => $model]);
	        	}
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
