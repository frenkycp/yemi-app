<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\search\WipBlueListSearch2;
use app\models\WipPlanActualReport;
use app\models\WipDtr;
use app\models\WipLocation;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\helpers\Json;

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
	    $searchModel  = new WipBlueListSearch2;
	    //$searchModel->stage = '03-COMPLETED';
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$tmp_location = \Yii::$app->params['wip_location_arr'];

		/*$status_arr = WipPlanActualReport::find()->select('distinct(stage)')->orderBy('stage ASC')->all();

		$tmp_status = [];
		foreach ($status_arr as $status) {
			$splitted_stage = explode('-', $status->stage);
			$tmp_status[$status->stage] = $splitted_stage[1];
		}*/

		// validate if there is a editable input saved via AJAX
        /**/if (\Yii::$app->request->post('hasEditable')) {
            $data_id = \Yii::$app->request->post('editableKey');
            $model = WipDtr::findOne(['dtr_id' => $data_id]);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>'']);

            $posted = current($_POST['WipDtr']);
            $post = ['WipDtr' => $posted];

            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();
                /*$output = '';

                if (isset($posted['unloading_time'])) {
                    $output = $model->unloading_time;
                }*/

                $out = Json::encode(['output'=>$model->gojek_req_qty, 'message'=>'']);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;
        }

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'location_dropdown' => $tmp_location,
		    //'status_dropdown' => $tmp_status
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
				$wip_data = WipPlanActualReport::find()->where([
					'slip_id' => $value
				])->one();
				$sql = "{CALL CALL_GOJEK(:slip_id, :item, :item_desc, :from_loc, :to_loc, :source, :requestor, :request_time)}";
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