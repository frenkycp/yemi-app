<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\MinimumStockView02;
use app\models\MinimumStockView03;
use yii\web\Response;
use yii\helpers\Json;
use app\models\search\MntMinimumStockSearch;
use dmstr\bootstrap\Tabs;
use yii\web\JsExpression;

/**
* This is the class for controller "MntMinimumStockController".
*/
class MntMinimumStockController extends \app\controllers\base\MntMinimumStockController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
	{
	    $searchModel  = new MntMinimumStockSearch;
	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		$tmp_stock = MinimumStockView03::find()->select([
			'ONHAND_STATUS', 'ONHAND_STATUS_DESC',
			'total_item' => 'COUNT(ITEM)'
		])->groupBy('ONHAND_STATUS, ONHAND_STATUS_DESC')->orderBy('ONHAND_STATUS_DESC')->all();

		$tmp_data = $data = [];
		$color_index_arr = ['#dd4b39', '#e5f312', '#f39c12', '#00a65a'];

		foreach ($tmp_stock as $key => $value) {
			$tmp_data[] = [
				'name' => $value->ONHAND_STATUS_DESC,
				'y' => (int)$value->total_item,
				'color' => $color_index_arr[$key],
			];
		}

		$data = [
			[
				'name' => 'Progress Percentage',
				'data' => $tmp_data
			]
		];

		$dropdown_status = ArrayHelper::map(MinimumStockView03::find()->select('ONHAND_STATUS_DESC, ONHAND_STATUS_DESC')->groupBy('ONHAND_STATUS_DESC, ONHAND_STATUS_DESC')->orderBy('ONHAND_STATUS_DESC')->all(), 'ONHAND_STATUS_DESC', 'ONHAND_STATUS_DESC');

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		    'data' => $data,
		    'dropdown_status' => $dropdown_status,
		]);
	}

    public function actionGetImagePreview($urutan)
	{
		//return \Yii::$app->urlManager->createUrl('uploads/NG_MNT/' . $urutan . '.jpg');
		//$src = \Yii::$app->request->BaseUrl . '/uploads/NG_MNT/' . $urutan . '.jpg';
		//$src = \Yii::$app->basePath. '\uploads\NG_MNT\\' . $urutan . '.jpg';
		$src = Html::img('http://10.110.52.5:84/product_image/' . $urutan . '.jpg', ['width' => '100%']);
		$tmp_item = MinimumStockView02::find()
		->where([
			'ITEM' => $urutan
		])
		->one();
		//return $src;
		return '<div class="text-center"><span><b>' . $tmp_item->ITEM_EQ_DESC_01 . '</b></span><br/>' . Html::img('http://10.110.52.5:84/product_image/' . $urutan . '.jpg',
			[
				'width' => '100%',
				'alt' => $urutan . '.jpg not found.'
			]) . '</div>';
		if (@getimagesize($src)) {
			return Html::img('@web/uploads/NG_MNT/' . $urutan . '.jpg', ['width' => '100%']);
		}
		return 'No Image Found...';
	}

	public function actionOrder()
	{
		$response = [];
		if (\Yii::$app->request->isAjax) {
			$response = [
				'success' => true,
				'message' => 'Plan was created successfully...',
			];

			\Yii::$app->response->format = Response::FORMAT_JSON;
			$data_post = \Yii::$app->request->post();
			$order_arr = json_decode($data_post['order_arr']);
			$item_str = '';
			$qty_str = '';
			$nip_rcv_str = '';
			$account_str = '';
			$lt_str = '';
			$cost_dep_str = '';
			foreach ($order_arr as $value) {
				$item_str .= $value->item . ',';
				$qty_str .= $value->req_qty . ',';
				$nip_rcv_str .= $value->nip_rcv . ',';
				$account_str .= $value->account . ',';
				$lt_str .= $value->lt . ',';
				$cost_dep_str .= $value->cost_dep . ',';
			}

			$sql = "{CALL SPARE_PART_TO_PR(:item, :qty, :NIP_RCV, :ACCOUNT, :LT, :PR_COST_DEP, :USER_ID)}";
			$params = [
				':item' => $item_str,
				':qty' => $qty_str,
				':NIP_RCV' => $nip_rcv_str,
				':ACCOUNT' => $account_str,
				':LT' => $lt_str,
				':PR_COST_DEP' => $cost_dep_str,
				':USER_ID' => \Yii::$app->user->identity->username,
			];
			try{
				$result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryOne();
				if (strpos($result['hasil'], 'IMR') !== false) {
					$response = [
						'success' => true,
						'message' => $result['hasil'],
					];
				} else {
					$response = [
						'success' => false,
						'message' => $result['hasil'],
					];
				}
			} catch (Exception $ex) {
				$msg = (isset($ex->errorInfo[2]))?$ex->errorInfo[2]:$ex->getMessage();
				$response = [
					'success' => false,
					'message' => 'Create order failed... ' . $msg,
					//'message' => $msg,
				];
			}
			
		}
		return $response;
	}
}
