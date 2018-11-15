<?php

namespace app\controllers;

use app\models\search\MaterialBlueListSearch;
use app\models\WipPlanActualReport;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
/**
* This is the class for controller "MaterialBlueListController".
*/
class MaterialBlueListController extends \app\controllers\base\MaterialBlueListController
{
	public function actionIndex()
	{
		$location_dropdown = ArrayHelper::map(WipPlanActualReport::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');

	    $searchModel  = new MaterialBlueListSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $location_dropdown,
		]);
	}

	public function actionOrder()
	{
		$response = [];
		if (\Yii::$app->request->isAjax) {
			\Yii::$app->response->format = Response::FORMAT_JSON;
			$data_post = \Yii::$app->request->post();
			$str_order = $data_post['value'];
			$destination = $data_post['destination'];
			$request_time = $data_post['request_time'];
			$order_arr = explode(',', $str_order);
			//$order_arr = ['0001981', '0001982'];

			$response = [
				'success' => true,
				'message' => 'Order was created successfully',
			];

			/**/foreach ($order_arr as $key => $value) {
				$material_data = VisualPickingList::find()->where([
					'set_list_no' => $value
				])->one();
				$sql = "{CALL CALL_GOJEK(:slip_id, :item, :item_desc, :from_loc, :to_loc, :source, :requestor, :request_time)}";
				//$sql = "{CALL SPARE_PART_STOCK(:MACHINE)}";
				// passing the params into to the sql query
				$params = [
					':slip_id' => $value,
					':item' => $material_data->parent,
					':item_desc' => $material_data->parent_desc,
					':from_loc' => 'WAREHOUSE',
					':to_loc' => $destination,
					':source' => 'MAT',
					':requestor' => \Yii::$app->user->identity->username,
					//':requestor' => '150826',
					':request_time' => $request_time,
				];
				// execute the sql command
				try {
				    $result = \Yii::$app->db_sql_server->createCommand($sql, $params)->execute();
				} catch (Exception $ex) {
					$response = [
						'success' => false,
						'message' => 'Order failed. ' . $ex->getMessage(),
					];
				}
			}
			
			return $response;
		}
	}
}