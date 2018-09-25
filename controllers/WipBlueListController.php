<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\WipBlueListSearch;
use app\models\WipPlanActualReport;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class WipBlueListController extends Controller
{
    /**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	/**
	* Lists all CisClientIpAddress models.
	* @return mixed
	*/
	public function actionIndex()
	{
	    $searchModel  = new WipBlueListSearch;
	    //$searchModel->stage = '03-COMPLETED';
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$tmp_location = ArrayHelper::map(WipPlanActualReport::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->all(), 'child_analyst_desc', 'child_analyst_desc');

		$status_arr = WipPlanActualReport::find()->select('distinct(stage)')->orderBy('stage ASC')->all();

		$tmp_status = [];
		foreach ($status_arr as $status) {
			$splitted_stage = explode('-', $status->stage);
			$tmp_status[$status->stage] = $splitted_stage[1];
		}

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $tmp_location,
		    'status_dropdown' => $tmp_status
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
			$order_arr = explode(',', $str_order);
			//$order_arr = ['0001981', '0001982'];

			$response = [
				'success' => true,
				'message' => 'Order was created successfully',
			];

			/**/foreach ($order_arr as $key => $value) {
				$wip_data = WipPlanActualReport::find()->where([
					'slip_id' => $value
				])->one();
				$sql = "{CALL CALL_GOJEK(:slip_id, :item, :item_desc, :from_loc, :to_loc, :source, :requestor)}";
				//$sql = "{CALL SPARE_PART_STOCK(:MACHINE)}";
				// passing the params into to the sql query
				$params = [
					':slip_id' => $value,
					':item' => $wip_data->child,
					':item_desc' => $wip_data->child_desc,
					':from_loc' => $wip_data->child_analyst_desc,
					':to_loc' => $destination,
					':source' => 'WIP',
					':requestor' => \Yii::$app->user->identity->username,
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