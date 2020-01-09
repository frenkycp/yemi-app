<?php

namespace app\controllers;

use app\models\ProdAttendanceMpPlan;
use app\models\Karyawan;
use yii\helpers\Url;

/**
* This is the class for controller "ProdAttendancePlanController".
*/
class ProdAttendancePlanController extends \app\controllers\base\ProdAttendancePlanController
{
	public function actionCreatePlan()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'manpower', 'location', 'shift'
        ]);
        $model->addRule(['from_date', 'to_date', 'manpower', 'location', 'shift'], 'required');
        $location_arr = \Yii::$app->params['wip_location_arr'];

        if ($model->load($_POST)) {
        	$bulkInsertArray = array();
        	$creator = Karyawan::find()->where([
        		'OR',
        		['NIK' => \Yii::$app->user->identity->username],
        		['NIK_SUN_FISH' => \Yii::$app->user->identity->username]
        	])->one();
        	if ($creator->NIK_SUN_FISH != null) {
        		foreach ($model->manpower as $key => $value) {
		    		$split_mp = explode(' - ', $value);
		    		$bulkInsertArray[] = [
		    			$model->location, $location_arr[$model->location], $split_mp[0], $split_mp[1], $model->from_date, $model->to_date, date('Y-m-d H:i:s'), $creator->NIK_SUN_FISH, $model->shift
		    		];
		    	}
		    	
	        	$insertCount = 0;
	        	if(count($bulkInsertArray) > 0){
	        		$columnNameArray = ['child_analyst', 'child_analyst_desc', 'nik', 'name', 'from_date', 'to_date', 'created_date', 'created_by_id', 'shift'];
	        		$insertCount = \Yii::$app->db_sql_server->createCommand()
	        		->batchInsert(ProdAttendanceMpPlan::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
	        		->execute();
	        	}
	        	\Yii::$app->getSession()->addFlash('success', $insertCount . ' manpower data inserted...');
				return $this->redirect(Url::previous());
        	} else {
        		\Yii::$app->getSession()->addFlash('warning', 'You\'re using invalid username for input !');
        	}
        	
        }

		return $this->render('create-plan', [
			'model' => $model,
			'location_arr' => $location_arr,
		]);
	}
}
