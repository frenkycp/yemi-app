<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\ClinicDataSearch;
use app\models\KlinikInput;
use app\models\KlinikHandle;
use app\models\Karyawan;
use app\models\CostCenter;
use app\models\KlinikObatLog;
use app\models\HrgaDrugMaster;
use app\models\HrgaDrugInOut;
use yii\helpers\Json;

/**
* This is the class for controller "ClinicDataController".
*/
class ClinicDataController extends \app\controllers\base\ClinicDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new ClinicDataSearch;

	    $searchModel->input_date = date('Y-m-d');
        if (\Yii::$app->request->get('input_date') !== null) {
            $searchModel->input_date = \Yii::$app->request->get('input_date');
        }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		if (\Yii::$app->request->post('hasEditable')) {
            // instantiate your book model for saving
            $pk = \Yii::$app->request->post('editableKey');
            $model = KlinikInput::findOne(['pk' => $pk]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['KlinikInput']);
            $post = ['KlinikInput' => $posted];

            if ($model->load($post)) {
                $model->save();
            }
            echo $out;
            return;
        }

        $tmp_dept = CostCenter::find()->select('CC_GROUP')->groupBy('CC_GROUP')->orderBy('CC_GROUP')->all();
        $dept_arr = [];
        foreach ($tmp_dept as $key => $value) {
        	$dept = $value->CC_GROUP;
        	if ($dept == 'FINANCE & ACCOUNTING') {
        		$dept = 'FINANCE AND ACCOUNTING';
        	}
        	$dept_arr[$dept] = $dept;
        }

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'dept_arr' => $dept_arr,
		]);
	}

	public function actionDelete($pk)
	{
		try {
			$for_delete = $this->findModel($pk);

			$input_log = KlinikObatLog::find()->where([
				'klinik_input_pk' => $for_delete->klinik_input_id
			])->all();
			if (count($input_log) > 0) {
				HrgaDrugInOut::deleteAll(['klinik_input_id' => $for_delete->klinik_input_id]);
				foreach ($input_log as $value) {
					$master_obat = HrgaDrugMaster::find()->where(['drug_master_partnumb' => $value->part_no])->one();
					$master_obat->stock_qty += $value->qty;
					$master_obat->save();
				}
				KlinikObatLog::deleteAll(['klinik_input_pk' => $for_delete->klinik_input_id]);
			}

			$for_delete->delete();
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$pk',',');
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

	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new KlinikInput;
		$total_obat = 0;
		$todays_date = date('Y-m-d');
		$todays_period = date('Ym');
		$todays_datetime = date('Y-m-d H:i:s');

		try {
			if ($model->load($_POST)) {
				$tmp_id = \Yii::$app->user->identity->username;
				$tmp_name = \Yii::$app->user->identity->name;

				$tmp_karyawan = Karyawan::find()->where([
					'OR',
					['NIK' => $tmp_id],
					['NIK_SUN_FISH' => $tmp_id]
				])->one();
				if ($tmp_karyawan) {
					$tmp_id = $tmp_karyawan->NIK_SUN_FISH;
					$tmp_name = $tmp_karyawan->NAMA_KARYAWAN;
				}
				
				$model->pk = date('Y-m-d H:i:s');
				$model->masuk = date('H:i:s');
				$klinik_input_id = strtotime(date('Y-m-d H:i:s')) . '';
				$model->klinik_input_id = $klinik_input_id;
				$qty_arr = $_POST['KlinikInput']['jumlah_obat'];
				
				foreach ($_POST['KlinikInput']['nama_obat'] as $key => $value) {
					if ($value != '' && $value != null) {
						$qty_obat = 0;
						if ($qty_arr[$key] != '' && $qty_arr[$key] != null) {
							$qty_obat = $qty_arr[$key];
						}
						$tmp_obat = HrgaDrugMaster::find()->where([
							'drug_master_partnumb' => $value
						])->one();

						$new_log = new KlinikObatLog;
						$new_log->klinik_input_pk = $klinik_input_id;
						$new_log->period = $todays_period;
						$new_log->post_date = $todays_date;
						$new_log->input_datetime = $todays_datetime;
						$new_log->user_id = $tmp_id;
						$new_log->user_name = $tmp_name;
						$new_log->part_no = $value;
						$new_log->part_desc = $tmp_obat->drug_master_partname;
						$new_log->qty = $qty_obat;

						if (!$new_log->save()) {
							return json_encode($new_log->errors);
						}

						$in_out = new HrgaDrugInOut;
						$in_out->drug_in_out_date = $todays_date;
						$in_out->drug_in_out_partnumb = $value;
						$in_out->drug_in_out_partname = $tmp_obat->drug_master_partname;
						$in_out->drug_in_out_qty = $qty_obat;
						$in_out->drug_in_out_unit = $tmp_obat->drug_master_unit_using;
						$in_out->drug_in_out_userid_update = $tmp_id;
						$in_out->drug_in_out_username_update = $tmp_name;
						$in_out->drug_in_out_datetime_update = $todays_datetime;
						$in_out->drug_in_out_note = 'OUT CLINIC';
						$in_out->drug_out_clinic = 'Y';
						$in_out->drug_in_out_status = 'OUT';
						$in_out->klinik_input_id = $klinik_input_id;

						if (!$in_out->save()) {
							return json_encode($in_out->errors);
						}

						$tmp_obat->stock_qty -= $qty_obat;
						if (!$tmp_obat->save()) {
							return json_encode($tmp_obat->errors);
						}
					}
				}

				if (in_array($model->CC_ID, ['250', '251'])) {
					$model->dept = 'PDC';
				}

				$count_status = KlinikHandle::find()
				->where(['status' => 1])
				->count();
				if ($count_status == 0) {
					\Yii::$app->session->setFlash("warning", "Tidak ada paramedis. Data tidak dapat ditambahkan ...");
					return $this->redirect(Url::previous());
				} elseif ($count_status == 1) {
					$paramedis = KlinikHandle::findOne(['status' => 1]);
					$model->handleby = $paramedis->pk;
				} else {
					$model->handleby = 'doctor';
				}

				if ($model->save()) {
					return $this->redirect(Url::previous());
				} else {
					return json_encode($model->errors());
				}
				
			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}
		return $this->render('create', [
			'model' => $model,
			'total_obat' => $total_obat,
		]);
	}

	public function actionCheckOut()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new \yii\base\DynamicModel([
	        'nik_sun_fish'
	    ]);
	    $model->addRule(['nik_sun_fish'], 'required');

	    if($model->load(\Yii::$app->request->post())){
	        $nik_sun_fish = $model->nik_sun_fish;

	        $tmp_data = KlinikInput::find()
	        ->where([
	        	'nik_sun_fish' => $nik_sun_fish,
	        	'DATE(pk)' => date('Y-m-d')
	        ])
	        ->orderBy('pk DESC')
	        ->limit(1)
	        ->one();

	        if ($tmp_data->nik_sun_fish == null) {
	        	\Yii::$app->session->setFlash("warning", "NIK : $nik_sun_fish tidak ada di klinik ...");
	        	return $this->redirect(Url::previous());
	        } else {
	        	$tmp_data->keluar = date('H:i:s');
	        	if (!$tmp_data->save()) {
		        	return json_encode($model->errors());
		        } else {
		        	\Yii::$app->session->setFlash("success", "NIK : $nik_sun_fish berhasil cek out ...");
		        }
	        }
	        
	        return $this->redirect(Url::previous());
	    }

	    return $this->renderAjax('check-out', [
    		'model' => $model
    	]);
	}

	public function actionChangeStatus($pk)
	{
		$tmp_data = KlinikHandle::find()
		->where(['pk' => $pk])
		->one();

		if ($tmp_data->status == 0) {
			$tmp_data->status = 1;
		} else {
			$tmp_data->status = 0;
		}

		if (!$tmp_data->save()) {
			return json_encode($tmp_data->errors);
		}

		return $this->redirect(Url::previous());
	}

	public function actionEmpInfo($nik)
	{
		$emp = Karyawan::findOne(['NIK_SUN_FISH' => $nik]);
		$data = [
			'name' => $emp->NAMA_KARYAWAN,
			'dept' => $emp->DEPARTEMEN,
			'section' => $emp->SECTION
		];
		return $emp->NAMA_KARYAWAN . '||' . $emp->DEPARTEMEN . '||' . $emp->SECTION . '||' . $emp->STATUS_KARYAWAN . '||' . $emp->CC_ID;
	}
}
