<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\ServerMachineIotCurrent;
use app\models\WipEffTbl;
use app\models\MachineIotOutput;
use app\models\Karyawan;
use app\models\BeaconTbl;
use yii\helpers\Url;

class MachineRunningController extends Controller
{
	public function actionLogin()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = \Yii::$app->session;
        if ($session->has('mcr_user')) {
            return $this->redirect(['index']);
        }
        $this->layout = "machine-running\login";

        $model = new \yii\base\DynamicModel([
            'username', 'password'
        ]);
        $model->addRule(['username', 'password'], 'required');

        if($model->load(\Yii::$app->request->post())){
            $karyawan = Karyawan::find()
            ->where([
                'NIK' => $model->username,
                'PASSWORD' => $model->password,
            ])
            ->one();
            if ($karyawan->NIK !== null) {
                $session['mcr_user'] = $model->username;
                $session['mcr_name'] = $karyawan->NAMA_KARYAWAN;
                return $this->redirect(['index']);
            } else {
                \Yii::$app->getSession()->setFlash('error', 'Incorrect username or password...');
            }
            $model->username = null;
            $model->password = null;
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    public function actionLogout()
    {
        $session = \Yii::$app->session;
        if ($session->has('mcr_user')) {
            $session->remove('mcr_user');
            $session->remove('mcr_name');
        }

        return $this->redirect(['login']);
    }

	public function getSeconds($start, $end)
	{
		$start_date = new \DateTime($start);
		$since_start = $start_date->diff(new \DateTime($end));
		$seconds = $since_start->days * 24 * 3600;
		$seconds += $since_start->h * 3600;
		$seconds += $since_start->i * 60;
		$seconds += $since_start->s;
		return $seconds;
	}

	public function actionIndex()
	{
		$session = \Yii::$app->session;
        if (!$session->has('mcr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['mcr_user'];
		$this->layout = 'clean';
		Url::remember();
		$mesin_id = '';
        date_default_timezone_set('Asia/Jakarta');
        $data = $lot_data = null;
        $mesin_description = '';
        //$current_data = [];
        $model = new \yii\base\DynamicModel([
            'mesin_id'
        ]);
        $model->addRule(['mesin_id'], 'required');

        if ($model->load($_GET)) {
        	$mesin_id = $model->mesin_id;
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

        	$output_data = MachineIotOutput::find()
        	->where([
        		'mesin_id' => $mesin_id,
        		'lot_number' => $tmp_data->lot_number
        	])
        	->andWhere('end_date IS NULL')
        	->one();
        }

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
			'output_data' => $output_data,
			'current_data' => $current_data,
			'lot_data' => $lot_data,
			'mesin_description' => $mesin_description,
			'mesin_id' => $mesin_id,
			'mcr_name' => $session['mcr_name']
		]);
	}

	public function actionStartMachine($mesin_id='', $lot_id = '')
	{
		$session = \Yii::$app->session;
        if (!$session->has('mcr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['mcr_user'];
        $name = $session['mcr_name'];

		$this->layout = 'clean';
		date_default_timezone_set('Asia/Jakarta');
		$model = new \yii\base\DynamicModel([
	        'man_power', 'beacon_id'
	    ]);
	    $model->addRule(['man_power', 'beacon_id'], 'required');

	    $tmp_mio = MachineIotOutput::find()
    	->where([
    		'lot_number' => $lot_id
    	])
    	->orderBy('seq DESC')
    	->one();

    	$model->beacon_id = $tmp_mio->minor;
	    //\Yii::$app->getSession()->addFlash('error', $msg);
	    if ($model->load($_POST)) {
	    	$beacon_id_current = $tmp_mio->minor;

	    	if ($tmp_mio->seq == null) {
	    		$isNewRecord = true;
	    		$beacon_tbl = BeaconTbl::find()
		    	->where(['minor' => $model->beacon_id])
		    	->one();

		    	if ($beacon_tbl->id == null) {
		    		\Yii::$app->session->setFlash("warning", "Beacon ID not found! Please input the correct ID.");
		    		return $this->render('start', [
			    		'model' => $model,
			    		'isNewRecord' => true,
			    	]);
		    	} else {
		    		if ($beacon_tbl->lot_number != null) {
		    			\Yii::$app->session->setFlash("warning", "Beacon was being used! Please select another one.");
			    		return $this->render('start', [
				    		'model' => $model,
				    		'isNewRecord' => true,
				    	]);
		    		} else {
		    			$beacon_tbl->lot_number = $lot_id;
		    			$beacon_tbl->start_date = date('Y-m-d H:i:s');
		    			if (!$beacon_tbl->save()) {
		    				return json_encode($beacon_tbl->errors);
		    			}
		    			$beacon_id_current = $beacon_tbl->minor;
		    		}
		    	}
	    	} else {
	    		$isNewRecord = false;
	    	}

	    	

	    	$man_power_name = '';
	    	$man_power_qty = count($model->man_power);
	    	foreach ($model->man_power as $key => $value) {
	    		$split_mp = explode(' - ', $value);
	    		if ($man_power_name == '') {
	    			$man_power_name = $split_mp[1];
	    		} else {
	    			$man_power_name .= ', ' . $split_mp[1];
	    		}
	    	}
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
	    		$slip_id_arr = [
    				$lot_data->slip_id_01,
    				$lot_data->slip_id_02,
    				$lot_data->slip_id_03,
    				$lot_data->slip_id_04,
    				$lot_data->slip_id_05,
    				$lot_data->slip_id_06,
    				$lot_data->slip_id_07,
    				$lot_data->slip_id_08,
    				$lot_data->slip_id_09,
    				$lot_data->slip_id_10
    			];
    			foreach ($slip_id_arr as $key => $value) {
    				if ($value != null) {
    					$sql = "{CALL WIP_02_STARTED(:slip_id, :USER_ID)}";
    					$params = [
							':slip_id' => $value,
							':USER_ID' => $nik,
						];

						try {
						    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
						    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been started ...');
						} catch (Exception $ex) {
							\Yii::$app->session->setFlash('danger', "Error : $ex");
						}
    				}
    			}
	    	}
	    	if (!$lot_data->save()) {
	    		return json_encode($lot_data->errors);
	    	}

	    	$current_data->lot_number = $lot_id;
	    	$current_data->gmc = $lot_data->child_all;
	    	$current_data->gmc_desc = $lot_data->child_desc_all;
	    	$current_data->lot_qty = $lot_data->qty_all;
	    	$current_data->model_group = $lot_data->model_group;
	    	$current_data->parent = $lot_data->parent;
	    	$current_data->parent_desc = $lot_data->parent_desc;
	    	if ($current_data->save()) {
	    		$iot_output = new MachineIotOutput;
	    		$iot_output->mesin_id = $mesin_id;
	    		$iot_output->mesin_description = $current_data->mesin_description;
	    		$iot_output->kelompok = $lot_data->jenis_mesin;
	    		$iot_output->lot_number = $lot_id;
	    		$iot_output->model_group = $lot_data->model_group;
	    		$iot_output->parent = $lot_data->parent;
	    		$iot_output->parent_desc = $lot_data->parent_desc;
	    		$iot_output->gmc = $lot_data->child_all;
	    		$iot_output->gmc_desc = $lot_data->child_desc_all;
	    		$iot_output->lot_qty = $lot_data->qty_all;
	    		$iot_output->start_date = date('Y-m-d H:i:s');
	    		$iot_output->start_by_id = $nik;
	    		$iot_output->start_by_name = $name;
	    		$iot_output->man_power_qty = $man_power_qty;
	    		$iot_output->man_power_name = $man_power_name;
	    		$iot_output->minor = $beacon_id_current;
	    		if (!$iot_output->save()) {
	    			return json_encode($iot_output->errors);
	    		}
	    		return $this->redirect(Url::previous());
	    	} else {
	    		return json_encode($current_data->errors);
	    	}
	    	
	    }

    	return $this->render('start', [
    		'model' => $model,
    		'isNewRecord' => $isNewRecord,
    	]);
    	
	}

	public function getPostingShift($end_date)
	{
		if ($end_date >= date('Y-m-d 07:00:00') && $end_date <= date('Y-m-d 15:59:59')) {
			$return_data['posting_shift'] = date('Y-m-d');
			$return_data['shift'] = 1;
		}
		if ($end_date >= date('Y-m-d 16:00:00') && $end_date <= date('Y-m-d 21:59:59')) {
			$return_data['posting_shift'] = date('Y-m-d');
			$return_data['shift'] = 2;
		}
		if ($end_date <= date('Y-m-d 06:59:59') && $end_date >= date('Y-m-d 00:00:00')) {
			$return_data['posting_shift'] = date('Y-m-d', strtotime('-1 day'));
			$return_data['shift'] = 3;
		}
		if ($end_date >= date('Y-m-d 22:00:00') && $end_date <= date('Y-m-d 23:59:59')) {
			$return_data['posting_shift'] = date('Y-m-d');
			$return_data['shift'] = 3;
		}
		return $return_data;
	}

	public function actionFinish($mesin_id)
	{
		$session = \Yii::$app->session;
        if (!$session->has('mcr_user')) {
            return $this->redirect(['login']);
        }
        $nik = $session['mcr_user'];
        $name = $session['mcr_name'];

		$this->layout = 'clean';
		date_default_timezone_set('Asia/Jakarta');
    	$model = new \yii\base\DynamicModel([
	        'next_process'
	    ]);
	    $model->addRule('next_process', 'required');

	    try{
	    	if ($model->load(\Yii::$app->request->post())) {
		    	$next_process = $model->next_process;

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
		    	$lot_data->plan_run = 'E';

		    	$current_data->lot_number = null;
		    	$current_data->gmc = null;
		    	$current_data->gmc_desc = null;
		    	$current_data->lot_qty = null;

		    	$iot_output = MachineIotOutput::find()
		    	->where([
		    		'mesin_id' => $mesin_id,
		    		'lot_number' => $lot_id
		    	])
		    	->andWhere('end_date IS NULL')
		    	->one();
		    	$iot_output->end_date = date('Y-m-d H:i:s');
		    	$iot_output->end_by_id = $nik;
		    	$iot_output->end_by_name = $name;
		    	$iot_output->lama_proses = $this->getSeconds($iot_output->start_date, $iot_output->end_date);
		    	$posting_shift_data = $this->getPostingShift($iot_output->end_date);
		    	$iot_output->posting_shift = $posting_shift_data['posting_shift'];
		    	$iot_output->shift = $posting_shift_data['shift'];
		    	if (!$iot_output->save()) {
		    		return json_encode($iot_output->errors);
		    	}

	    		if ($next_process == 'END') {
	    			$lot_data->end_date = date('Y-m-d H:i:s');
	    			
	    			$lot_data->plan_stats = 'C';
	    			$slip_id_arr = [
	    				$lot_data->slip_id_01,
	    				$lot_data->slip_id_02,
	    				$lot_data->slip_id_03,
	    				$lot_data->slip_id_04,
	    				$lot_data->slip_id_05,
	    				$lot_data->slip_id_06,
	    				$lot_data->slip_id_07,
	    				$lot_data->slip_id_08,
	    				$lot_data->slip_id_09,
	    				$lot_data->slip_id_10
	    			];
	    			$sql_lot = "{CALL MACHINE_OUTPUT_TIME_TABLE(:lot_number)}";
	    			$params_lot = [
						':lot_number' => $lot_id
					];
	    			try {
					    $result_lot = \Yii::$app->db_sql_server->createCommand($sql_lot, $params_lot)->execute();
					    foreach ($slip_id_arr as $key => $value) {
		    				if ($value != null) {
		    					$sql = "{CALL WIP_03_COMPLETED(:slip_id, :USER_ID)}";
		    					$params = [
									':slip_id' => $value,
									':USER_ID' => $nik,
								];

								try {
								    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
								    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
								} catch (Exception $ex) {
									\Yii::$app->session->setFlash('danger', "Error : $ex, $lot_id aaaaaaa");
								}
		    				}
		    			}
					    //\Yii::$app->session->setFlash('success', 'Slip number : ' . $value . ' has been completed ...');
					} catch (Exception $ex) {
						\Yii::$app->session->setFlash('danger', "Error : $ex, $lot_id aaaaaaa");
					}

					$tmp_beacon_tbl = BeaconTbl::find()->where([
						'minor' => $iot_output->minor
					])->one();
					$tmp_beacon_tbl->lot_number = null;
					$tmp_beacon_tbl->start_date = null;
	    			if (!$tmp_beacon_tbl->save()) {
	    				return json_encode($tmp_beacon_tbl->errors);
	    			}
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

    	return $this->render('finish', [
    		'model' => $model
    	]);
	}
}