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

	public function actionCreate($YCJ_REF_NO = '')
	{
		$model = new ShipReservationDtr;
		date_default_timezone_set('Asia/Jakarta');
		$this_time = date('Y-m-d H:i:s');

		if ($YCJ_REF_NO == '') {
			$total_ycj_ref_no = ShipReservationHdr::find()->count();
			$count_str = str_pad($total_ycj_ref_no + 1, 4, "0", STR_PAD_LEFT);
			$model->YCJ_REF_NO = 'YEMI' . $count_str;
		} else {
			$model->YCJ_REF_NO = $YCJ_REF_NO;
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
				$model->UPDATED_BY_ID = $model->CREATED_BY_ID;
				$model->UPDATED_BY_NAME = $model->CREATED_BY_NAME;
				
				$tmp_ship_liner = ShipLiner::findOne($model->CARRIER);
				$model->POD = $tmp_ship_liner->POD;
				$model->CARRIER = $tmp_ship_liner->CARRIER;
				$model->FLAG_DESC = $tmp_ship_liner->FLAG_DESC;
				$model->FLAG_PRIORITY = $tmp_ship_liner->FLAG_PRIORITY;
				if (!$model->save()) {
					return json_encode($model->errors);
				}

				$hdr = ShipReservationHdr::find()->where(['YCJ_REF_NO' => $model->YCJ_REF_NO])->one();
				if (!$hdr) {
					$hdr = new ShipReservationHdr;
					$hdr->YCJ_REF_NO = $model->YCJ_REF_NO;
				}

				$tmp_total_container = ShipReservationDtr::find()->select([
					'CNT_40HC' => 'SUM(CNT_40HC)',
					'CNT_40' => 'SUM(CNT_40)',
					'CNT_20' => 'SUM(CNT_20)',
				])
				->where(['YCJ_REF_NO' => $model->YCJ_REF_NO])
				->one();

				$hdr_remark = 'Total container for YCJ Ref. No. ' . $model->YCJ_REF_NO . ' : ';
				$total_container_type = 0;

				if (($tmp_total_container->CNT_40HC + $tmp_total_container->CNT_40 + $tmp_total_container->CNT_20) == 0) {
					$hdr_remark .= '0 container.';
				} else {
					if ($tmp_total_container->CNT_40HC > 0) {
						$hdr_remark .= $tmp_total_container->CNT_40HC . ' container(s) 40\'HC';
						$total_container_type++;
					}
					if ($tmp_total_container->CNT_40 > 0) {
						if ($total_container_type > 0) {
							$hdr_remark .= ', ' . $tmp_total_container->CNT_40 . ' container(s) 40\'';
						} else {
							$hdr_remark .= $tmp_total_container->CNT_40 . ' container(s) 40\'';
						}
						$total_container_type++;
					}
					if ($tmp_total_container->CNT_20 > 0) {
						if ($total_container_type > 0) {
							$hdr_remark .= ', ' . $tmp_total_container->CNT_20 . ' container(s) 20\'';
						} else {
							$hdr_remark .= $tmp_total_container->CNT_20 . ' container(s) 20\'';
						}
					}
				}
				$hdr->RESERVATION_REMARK = $hdr_remark;
				if (!$hdr->save()) {
					return json_encode($hdr->errors);
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

	public function actionUpdate($SEQ)
	{
		$model = $this->findModel($SEQ);
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

				$hdr = ShipReservationHdr::find()->where(['YCJ_REF_NO' => $model->YCJ_REF_NO])->one();
				if (!$hdr) {
					$hdr = new ShipReservationHdr;
					$hdr->YCJ_REF_NO = $model->YCJ_REF_NO;
				}

				$tmp_total_container = ShipReservationDtr::find()->select([
					'CNT_40HC' => 'SUM(CNT_40HC)',
					'CNT_40' => 'SUM(CNT_40)',
					'CNT_20' => 'SUM(CNT_20)',
				])
				->where(['YCJ_REF_NO' => $model->YCJ_REF_NO])
				->one();

				$hdr_remark = 'Total container for YCJ Ref. No. ' . $model->YCJ_REF_NO . ' : ';
				$total_container_type = 0;

				if (($tmp_total_container->CNT_40HC + $tmp_total_container->CNT_40 + $tmp_total_container->CNT_20) == 0) {
					$hdr_remark .= '0 container.';
				} else {
					if ($tmp_total_container->CNT_40HC > 0) {
						$hdr_remark .= $tmp_total_container->CNT_40HC . ' container(s) 40\'HC';
						$total_container_type++;
					}
					if ($tmp_total_container->CNT_40 > 0) {
						if ($total_container_type > 0) {
							$hdr_remark .= ', ' . $tmp_total_container->CNT_40 . ' container(s) 40\'';
						} else {
							$hdr_remark .= $tmp_total_container->CNT_40 . ' container(s) 40\'';
						}
						$total_container_type++;
					}
					if ($tmp_total_container->CNT_20 > 0) {
						if ($total_container_type > 0) {
							$hdr_remark .= ', ' . $tmp_total_container->CNT_20 . ' container(s) 20\'';
						} else {
							$hdr_remark .= $tmp_total_container->CNT_20 . ' container(s) 20\'';
						}
					}
				}
				$hdr->RESERVATION_REMARK = $hdr_remark;
				if (!$hdr->save()) {
					return json_encode($hdr->errors);
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
