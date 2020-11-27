<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;
use app\models\ShipReservationDtr;
use app\models\ShipReservationHdr;
use app\models\search\ShipReservationDataSearch;
use app\models\ShipLiner;
use app\models\Karyawan;

/**
* This is the class for controller "ShipReservationDataController".
*/
class ShipReservationDataController extends \app\controllers\base\ShipReservationDataController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
	    $searchModel  = new ShipReservationDataSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
		'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionCarrier($POD_VAL = '', $CARRIER_VAL = '', $FLAG_DESC_VAL = '')
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$out = [];
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
	        if ($parents != null) {
	            $pod = $parents[0];
	            $tmp_data = ShipLiner::find()->where(['POD' => $pod])->orderBy('FLAG_PRIORITY')->all();
	            $data = [];
	            
	            if ($POD_VAL == '') {
	            	$selected = null;
	            } else {
	            	$tmp_selected = ShipLiner::find()->where([
	            		'POD' => $POD_VAL,
	            		'CARRIER' => $CARRIER_VAL,
	            		'FLAG_DESC' => $FLAG_DESC_VAL,
	            	])->one();
	            	if (!$tmp_selected->SEQ) {
	            		$selected = null;
	            	} else {
	            		$selected = $tmp_selected->SEQ;
	            	}
	            	
	            }
	            $first_selected = null;
	            $current_selected = null;
	            foreach ($tmp_data as $key => $value) {
	            	if ($selected == null) {
	            		$selected = $value->SEQ;
	            	} else {
	            		if ($selected == $value->SEQ) {
	            			$current_selected = $value->SEQ;
	            		}
	            	}
	            	if ($first_selected == null) {
	            		$first_selected = $value->SEQ;
	            	}
	            	$data[] = [
	            		'id' => $value->SEQ,
	            		'name' => $value->carrierDesc
	            	];
	            }
	            if ($current_selected != null) {
	            	$selected = $current_selected;
	            } else {
	            	$selected = $first_selected;
	            }
	            //$out = self::getSubCatList($pod); 
	            // the getSubCatList function will query the database based on the
	            // cat_id and return an array like below:
	            // [
	            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
	            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
	            // ]
	            return ['output' => $data, 'selected' => $selected];
	        }
		}
		return ['output' => '', 'selected' => ''];
	}

	public function actionDelete($DTR_ID)
	{
		try {
			$model = $this->findModel($DTR_ID);
			$model->FLAG = 0;

			$model->save();
			return $this->redirect(Url::previous());
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			\Yii::$app->getSession()->addFlash('error', $msg);
			return $this->redirect(Url::previous());
		}

		// TODO: improve detection
		$isPivot = strstr('$DTR_ID',',');
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

	public function actionCreate($HDR_ID = '')
	{
		$model = new ShipReservationDtr;
		date_default_timezone_set('Asia/Jakarta');
		$this_time = date('Y-m-d H:i:s');
		$model->ETD_SUB = date('Y-m-t');
		$model->PERIOD = date('Ym', strtotime($model->ETD_SUB));

		if ($HDR_ID == '') {
			$total_ycj_ref_no = ShipReservationHdr::find()->count();
			$count_str = str_pad($total_ycj_ref_no + 1, 3, "0", STR_PAD_LEFT);
			$model->YCJ_REF_NO = 'YEMI' . $count_str;
		} else {
			$tmp_dtr = ShipReservationDtr::find()->where([
				'HDR_ID' => $HDR_ID
			])->orderBy('LAST_UPDATE DESC')->one();
			$model->YCJ_REF_NO = $tmp_dtr->YCJ_REF_NO;
			$model->ETD = $tmp_dtr->ETD;
			$model->ETD_SUB = $tmp_dtr->ETD_SUB;
			$model->PERIOD = $tmp_dtr->PERIOD;
			$model->SHIPPER = $tmp_dtr->SHIPPER;
			$model->POL = $tmp_dtr->POL;
			$model->KD_FLAG = $tmp_dtr->KD_FLAG;
		}
		
		try {
			if ($model->load($_POST)) {
				$creator = Karyawan::find()->where([
	        		'OR',
	        		['NIK' => \Yii::$app->user->identity->username],
	        		['NIK_SUN_FISH' => \Yii::$app->user->identity->username]
	        	])->one();

				$model->CREATE_TIME = $this_time;
				$model->LAST_UPDATE = $this_time;
				if ($creator) {
					$model->CREATED_BY_ID = $creator->NIK_SUN_FISH;
					$model->CREATED_BY_NAME = $creator->NAMA_KARYAWAN;
				} else {
					$model->CREATED_BY_ID = \Yii::$app->user->identity->username;
					$model->CREATED_BY_NAME = \Yii::$app->user->identity->username;
				}
				
				$tmp_ship_liner = ShipLiner::findOne($model->CARRIER);
				$model->POD = $tmp_ship_liner->POD;
				$model->CARRIER = $tmp_ship_liner->CARRIER;
				$model->FLAG_DESC = $tmp_ship_liner->FLAG_DESC;
				$model->FLAG_PRIORITY = $tmp_ship_liner->FLAG_PRIORITY;
				$model->DTR_ID = $model->PERIOD . $model->YCJ_REF_NO . '_' . date('His', strtotime($this_time));
				if (!$model->save()) {
					return json_encode($model->errors);
				}

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

	public function actionUpdate($DTR_ID)
	{
		$model = $this->findModel($DTR_ID);
		/*$tmp_selected = ShipLiner::find()->where([
    		'POD' => $model->POD,
    		'CARRIER' => $model->CARRIER,
    		'FLAG_DESC' => $model->FLAG_DESC,
    	])->one();
    	$model->CARRIER = $tmp_selected->SEQ;*/

		if ($model->load($_POST)) {
			if ($model->save()) {
				$tmp_ship_liner = ShipLiner::findOne($model->CARRIER);
				$model->POD = $tmp_ship_liner->POD;
				$model->CARRIER = $tmp_ship_liner->CARRIER;
				$model->FLAG_DESC = $tmp_ship_liner->FLAG_DESC;
				$model->FLAG_PRIORITY = $tmp_ship_liner->FLAG_PRIORITY;
				if (!$model->save()) {
					return json_encode($model->errors);
				}

				return $this->redirect(Url::previous());
			} else {
				return json_encode($model->errors);
			}
			
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
}
