<?php

namespace app\controllers;

use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\ClinicDataSearch;
use app\models\KlinikInput;
use app\models\KlinikHandle;
use app\models\Karyawan;
use app\models\CostCenter;
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

	/**
	* Lists all KlinikInput models.
	* @return mixed
	*/
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

	/**
	* Creates a new KlinikInput model.
	* If creation is successful, the browser will be redirected to the 'view' page.
	* @return mixed
	*/
	public function actionCreate()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new KlinikInput;

		try {
			if ($model->load($_POST)) {
				$model->pk = date('Y-m-d H:i:s');
				$model->masuk = date('H:i:s');
				/*if ($model->opsi == 1) {
					$model->keluar = date('H:i:s', strtotime('+10 minutes'));
				} else {
					$model->keluar = date('H:i:s', strtotime('+1 hour'));
				}*/

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
		return $this->render('create', ['model' => $model]);
	}

	public function actionCheckOut()
	{
		date_default_timezone_set('Asia/Jakarta');
		$model = new \yii\base\DynamicModel([
	        'nik'
	    ]);
	    $model->addRule(['nik'], 'required');

	    if($model->load(\Yii::$app->request->post())){
	        $nik = $model->nik;

	        $tmp_data = KlinikInput::find()
	        ->where([
	        	'nik' => $nik,
	        	'DATE(pk)' => date('Y-m-d')
	        ])
	        ->orderBy('pk DESC')
	        ->limit(1)
	        ->one();

	        if ($tmp_data->nik == 0) {
	        	\Yii::$app->session->setFlash("warning", "NIK : $nik tidak ada di klinik ...");
	        	return $this->redirect(Url::previous());
	        } else {
	        	$tmp_data->keluar = date('H:i:s');
	        	if (!$tmp_data->save()) {
		        	return json_encode($model->errors());
		        } else {
		        	\Yii::$app->session->setFlash("success", "NIK : $nik berhasil cek out ...");
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
		$emp = Karyawan::findOne(['NIK' => $nik]);
		$data = [
			'name' => $emp->NAMA_KARYAWAN,
			'dept' => $emp->DEPARTEMEN,
			'section' => $emp->SECTION
		];
		return $emp->NAMA_KARYAWAN . '||' . $emp->DEPARTEMEN . '||' . $emp->SECTION . '||' . $emp->STATUS_KARYAWAN . '||' . $emp->CC_ID;
	}
}
