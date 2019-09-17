<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use yii\web\Response;
use yii\helpers\Json;

use app\models\WipLocation;
use app\models\MachineIotCurrent;
use app\models\search\ProductionSchedulerSearch;

class ProductionSchedulerController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	$searchModel  = new ProductionSchedulerSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$location_dropdown = ArrayHelper::map(WipLocation::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc');

		$jenis_mesin_dropdown = ArrayHelper::map(MachineIotCurrent::find()->select(['kelompok'])->groupBy('kelompok')->orderBy('kelompok')->all(), 'kelompok', 'kelompok');

    	return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $location_dropdown,
		    'jenis_mesin_dropdown' => $jenis_mesin_dropdown,
		]);
    }

    public function actionCreatePlan()
    {
    	$response = [];
		if (\Yii::$app->request->isAjax) {

			$response = [
				'success' => true,
				'message' => 'Plan was created successfully...',
			];

			\Yii::$app->response->format = Response::FORMAT_JSON;
			$data_post = \Yii::$app->request->post();
			$slip_str_val = $data_post['value'];
			$cb_arr_val = explode(',', $slip_str_val);
			$loc = $data_post['loc'];
			$loc_desc = $data_post['loc_desc'];
			$line = $data_post['line'];
			$shift = $data_post['shift'];
			$group = $data_post['group'];
			$plan_date = $data_post['plan_date'];

			$params = [
				':child_analyst' => $loc,
				':child_analyst_desc' => $loc_desc,
				':LINE' => $line,
				':SMT_SHIFT' => $shift,
				':KELOMPOK' => $group,
				':plan_date' => $plan_date,
			];

			//$tmp_no = '';
			for ($i = 0; $i < 10; $i++) {
				$tmp = '';
				if (isset($cb_arr_val[$i])) {
					$tmp = $cb_arr_val[$i];
				}
				$no = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
				//$tmp_no .= ':slip_id_' . $no . ' => ' . $tmp . ' | ';
				$params[':slip_id_' . $no] = $tmp;
			}

			//$response['message'] = $tmp_no;

			/*$sql = "{CALL WIP_RESERVATION_PLAN(:child_analyst, :child_analyst_desc, :LINE, :SMT_SHIFT, :KELOMPOK, :plan_date, :slip_id_01, :slip_id_02, :slip_id_03, :slip_id_04, :slip_id_05, :slip_id_06, :slip_id_07, :slip_id_08, :slip_id_09, :slip_id_10, :USER_ID)}";*/
			$sql = "{CALL WIP_RESERVATION_PLAN_IOT(:child_analyst, :child_analyst_desc, :LINE, :SMT_SHIFT, :KELOMPOK, :plan_date, :slip_id_01, :slip_id_02, :slip_id_03, :slip_id_04, :slip_id_05, :slip_id_06, :slip_id_07, :slip_id_08, :slip_id_09, :slip_id_10, :USER_ID, :mesin_id, :mesin_description, :jenis_mesin, :model_group)}";

			$params[':USER_ID'] = \Yii::$app->user->identity->username;
			$params[':mesin_id'] = '';
			$params[':mesin_description'] = '';
			$params[':jenis_mesin'] = $data_post['jenis_mesin'];
			$params[':model_group'] = $data_post['model_group'];

			try {
			    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->queryOne();
			    $pesan_arr = explode('-', $result['HASIL']);
			    $response['message'] = 'Lot number : ' . $pesan_arr[0] . ' was created successfully...';
			} catch (Exception $ex) {
				$response = [
					'success' => false,
					'message' => 'Create plan failed... ' . $ex->getMessage(),
				];
			}
			
			return $response;
		}
    }
}