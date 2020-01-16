<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\ProdAttendanceDailyPlan;
use app\models\Karyawan;
use app\models\search\ProdAttendanceDailyPlanSearch;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

/**
* This is the class for controller "ProdAttendancePlanController".
*/
class ProdAttendancePlanController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public $enableCsrfValidation = false;

	public function actionIndex()
	{
	    $searchModel  = new ProdAttendanceDailyPlanSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCreatePlan()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'manpower', 'location', 'shift'
        ]);
        $model->addRule(['from_date', 'to_date', 'manpower', 'location', 'shift'], 'required');
        $location_arr = \Yii::$app->params['wip_location_arr'];

        if ($model->load($_POST)) {
        	$shift_val = $model->shift;
        	$now = date('Y-m-d H:i:s');
        	$bulkInsertArray = array();
        	$creator = Karyawan::find()->where([
        		'OR',
        		['NIK' => \Yii::$app->user->identity->username],
        		['NIK_SUN_FISH' => \Yii::$app->user->identity->username]
        	])->one();

        	if ($creator->NIK_SUN_FISH != null) {
        		$trim_nik = trim(preg_replace('/\t+/', '', $model->manpower));
        		$nik_arr = preg_split("/\r\n|\n|\r/", $trim_nik);

        		$karyawan_arr = ArrayHelper::map(Karyawan::find()->select(['NIK_SUN_FISH', 'NAMA_KARYAWAN'])->where(['NIK_SUN_FISH' => $nik_arr])->all(), 'NIK_SUN_FISH', 'NAMA_KARYAWAN');

        		foreach ($nik_arr as $key => $value) {
        			if ($value == '' || $value == ' ') {
        				# code...
        			} else {
        				$nik = $value;
	        			$nama_karyawan = null;
	        			$child_analyst = $model->location;
	        			$child_analyst_desc = $location_arr[$model->location];
	        			$emp_shift = $model->shift;
	        			if (isset($karyawan_arr[$nik])) {
	        				$nama_karyawan = $karyawan_arr[$nik];
	        			}

	        			if ($model->from_date == $model->to_date) {
	        				$id = $model->from_date . $emp_shift . $nik;
	        				$period = date('Ym', strtotime($model->from_date));

	        				$tmp_find = ProdAttendanceDailyPlan::find()->where([
						    	'att_date' => $model->from_date,
						    	'nik' => $nik
						    ])->one();

        					if ($tmp_find->id != null) {
        						$tmp_find->child_analyst = $child_analyst;
						    	$tmp_find->child_analyst_desc = $child_analyst_desc;
						    	$tmp_find->emp_shift = $emp_shift;
						    	$tmp_find->save();
        					} else {
        						$bulkInsertArray[] = [
					    			$id, $period, $child_analyst, $child_analyst_desc, $nik, $nama_karyawan, $model->from_date, $now, $creator->NIK_SUN_FISH, $emp_shift
					    		];
        					}
	        				
	        			} else {
	        				$begin = new \DateTime($model->from_date);
							$end = new \DateTime($model->to_date);
							$end = $end->modify( '+1 day' );

							$interval = \DateInterval::createFromDateString('1 day');
							$period_interval = new \DatePeriod($begin, $interval, $end);

							foreach ($period_interval as $dt) {
							    $att_date = $dt->format('Y-m-d');
							    $period = date('Ym', strtotime($att_date));
							    $id = $att_date . $emp_shift . $nik;
							    $tmp_find = ProdAttendanceDailyPlan::find()->where([
							    	'att_date' => $att_date,
							    	'nik' => $nik
							    ])->one();
							    if ($tmp_find->id != null) {
							    	$tmp_find->child_analyst = $child_analyst;
							    	$tmp_find->child_analyst_desc = $child_analyst_desc;
							    	$tmp_find->emp_shift = $emp_shift;
							    	$tmp_find->save();
							    } else {
							    	$bulkInsertArray[] = [
						    			$id, $period, $child_analyst, $child_analyst_desc, $nik, $nama_karyawan, $att_date, $now, $creator->NIK_SUN_FISH, $emp_shift
						    		];
							    }
							    
							}
	        			}
        			}
        		}
		    	
	        	$insertCount = 0;
	        	if(count($bulkInsertArray) > 0){
	        		$columnNameArray = ['id', 'period', 'child_analyst', 'child_analyst_desc', 'nik', 'name', 'att_date', 'create_time', 'created_by_id', 'emp_shift'];
	        		$insertCount = \Yii::$app->db_sql_server->createCommand()
	        		->batchInsert(ProdAttendanceDailyPlan::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
	        		->execute();
	        	}
	        	\Yii::$app->getSession()->addFlash('success', $insertCount . ' MP Plan data inserted...');
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

	public function actionDelete($id)
	{
		try {
			$this->findModel($id)->delete();
			return $this->redirect(Url::previous());
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$id',',');
		if ($isPivot == true) {
			return $this->redirect(Url::previous());
		} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
			Url::remember(null);
			$url = \Yii::$app->session['__crudReturnUrl'];
			\Yii::$app->session['__crudReturnUrl'] = null;

			return $this->redirect($url);
		} else {
			return $this->redirect(['index']);
		}
	}

	protected function findModel($id)
	{
		if (($model = ProdAttendanceDailyPlan::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}
}
