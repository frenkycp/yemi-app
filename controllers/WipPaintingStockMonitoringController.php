<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\Response;
use app\models\WipStock02;

class WipPaintingStockMonitoringController extends Controller
{
	/**
	* @var boolean whether to enable CSRF validation for the actions in this controller.
	* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
	*/
	public $enableCsrfValidation = false;

    public function actionAjaxExample()
    {
    	Yii::$app->response->format = Response::FORMAT_JSON;
	    $post = Yii:: $app->request->post();
	    $data = [];
	    if (Yii::$app->request->isAjax) {
	        $nilai1= explode(":", $data['nilai1']);
    		$nilai2= explode(":", $data['nilai2']);
    		$nilai1= $nilai1[0];
    		$nilai2= $nilai1[1];
	        $data = (int)$nilai1 * (int)$nilai2;
	        
	        
	        return $data;
	    }
    }

    public function actionIndex()
    {
    	$wip_stock_view = WipStock02::find()->all();

    	$data = [];
    	foreach ($wip_stock_view as $value) {
    		$limit = $value->limit_qty * 1.2;
    		$data[$value->child_analyst_desc] = [
    			'stage' => $value->stage,
    			'onhand_qty' => $value->onhand_qty,
    			'limit_qty' => $limit,
    			'plot_green' => [
    				'from' => 0,
    				'to' => $value->limit_qty * 0.8,
    			],
    			'plot_yellow' => [
    				'from' => $value->limit_qty * 0.8,
    				'to' => $value->limit_qty * 1,
    			],
    			'plot_red' => [
    				'from' => $value->limit_qty,
    				'to' => $limit,
    			],
    		];
    	}

    	return $this->render('index', [
    		'data' => $data
    	]);
    }
}