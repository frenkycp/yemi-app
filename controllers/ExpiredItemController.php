<?php

namespace app\controllers;

use app\models\Karyawan;
use app\models\TraceItemDtr;
use app\models\TraceItemScrap;
use app\models\TraceItemRequestPc;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\Response;

class ExpiredItemController extends \app\controllers\base\ExpiredItemController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionPcJudgement()
    {
    	date_default_timezone_set('Asia/Jakarta');
		$last_update = date('Y-m-d H:i:s');

    	$response = [];
		if (\Yii::$app->request->isAjax) {

			$tmp_id = \Yii::$app->user->identity->username;
			$tmp_user = Karyawan::find()->where([
				'OR',
				['NIK' => $tmp_id],
				['NIK_SUN_FISH' => $tmp_id]
			])->one();

			if (!$tmp_user) {
				$response = [
					'success' => false,
					'message' => 'Process failed! User unregistered. Please contact administrator.',
				];
			}
			$tmp_name = $tmp_user->NAMA_KARYAWAN;

			\Yii::$app->response->format = Response::FORMAT_JSON;
			$data_post = \Yii::$app->request->post();
			$tmp_serno = $data_post['value'];
			$serno_arr_val = explode('|', $tmp_serno);
			$category = $data_post['category'];
			$po_no = $data_post['po_no'];
			$lot_no = $data_post['lot_no'];
			$item = $data_post['item'];
			$item_desc = $data_post['item_desc'];
			$uom = $data_post['uom'];
			$grandtotal = $data_post['grandtotal'];
			$vendor = $data_post['vendor'];
			$latest_expired_date = $data_post['latest_expired_date'];
			
			$tmp_request_id = $tmp_id . '_' . strtotime($last_update);

			if ($category == 2) {
				$new_request = new TraceItemRequestPc;
				$new_request->REQUEST_ID = $tmp_request_id;
				$new_request->LOT_NO = $lot_no;
				$new_request->CATEGORY = $category;
				$new_request->CREATE_BY_ID = $tmp_user->NIK_SUN_FISH;
				$new_request->CREATE_BY_NAME = $tmp_name;
				$new_request->CREATE_DATETIME = $last_update;
				$new_request->PO_NO = $po_no;
				$new_request->PLAN_QTY = $grandtotal;

				if ($new_request->save()) {
					TraceItemDtr::updateAll([
	                    'PO_NO' => $po_no,
	                    'REQUEST_ID' => $tmp_request_id,
	                    'SCRAP_REQUEST_STATUS' => $category
	                ], [
	                	'SERIAL_NO' => $serno_arr_val
	                ]);

	                $response = [
						'success' => true,
						'message' => 'Process competed!',
					];

					$this->sendPoIssuedEmail($category, $po_no, $item, $item_desc, $vendor, $grandtotal, $uom, $latest_expired_date, $lot_no, $tmp_request_id);
				} else {
					$response = [
						'success' => false,
						'message' => 'Process failed! ' . json_encode($model->errors),
					];
				}
			}
			
			return $response;
		}
    }

    public function sendPoIssuedEmail($category, $po_no, $item, $item_desc, $vendor, $grandtotal, $uom, $latest_expired_date, $lot_no, $request_id)
	{
		$msg = '
        PO has been issued with the following information :
        <ul>
            <li>PO No. : ' . $po_no . '</li>
            <li>Lot No. : ' . $lot_no . '</li>
            <li>Part No. : ' . $item . '</li>
            <li>Part Name : ' . $item_desc . '</li>
            <li>Supplier : ' . $vendor . '</li>
            <li>Qty (will be scrap) : ' . $grandtotal . '</li>
            <li>UOM : ' . $uom . '</li>
            <li style="color: red"><b>Request Expired Date (minimum) : ' . $latest_expired_date . '</b></li>
        </ul>
        <br/>
        Please make sure that incoming item has expired date more than requested above.<br/>
        Click ' . Html::a('HERE', 'http://10.110.52.5:86/expired-item-issued-po?REQUEST_ID=' . $request_id) . ' for more detail.
        <br/>
        Thanks & Best Regards,<br/>
        MITA
        ';

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $msg
        ])
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['frenky.purnama@music.yamaha.com', 'angga.adhitya@music.yamaha.com', 'fredy.agus@music.yamaha.com', 'hanik.lutfiah@music.yamaha.com', 'abdul.ghofur@music.yamaha.com'])
        //->setCc($set_to_cc_arr)
        ->setSubject('PO Issued for Expired Material')
        ->send();
	}
    
	public function actionScrap($SERIAL_NO)
	{
		$tmp_id = \Yii::$app->user->identity->username;
		$tmp_user = Karyawan::find()->where([
			'OR',
			['NIK' => $tmp_id],
			['NIK_SUN_FISH' => $tmp_id]
		])->one();

		if (!$tmp_user) {
			\Yii::$app->session->setFlash('warning', 'Failed to confirm. User unregistered. Please contact administrator.');
			return $this->redirect(Url::previous());
		}

		$tmp_scrap = TraceItemScrap::find()->where(['SERIAL_NO' => $SERIAL_NO])->one();
		if ($tmp_scrap) {
			\Yii::$app->session->setFlash('warning', 'Scrap request has been made.');
			return $this->redirect(Url::previous());
		}

		date_default_timezone_set('Asia/Jakarta');
		$last_update = date('Y-m-d H:i:s');
		$item = TraceItemDtr::find()->where(['SERIAL_NO' => $SERIAL_NO])->one();

    	$max_expired_date = TraceItemDtr::find()->select([
    		'EXPIRED_DATE' => 'MAX(EXPIRED_DATE)'
    	])->where(['ITEM' => $item->ITEM])->one();

    	$model = new TraceItemScrap;
    	$model->SERIAL_NO = $item->SERIAL_NO;
    	$model->LOT_NO = $item->LOT_NO;
    	$model->ITEM = $item->ITEM;
    	$model->ITEM_DESC = $item->ITEM_DESC;
    	$model->SUPPLIER = $item->SUPPLIER;
    	$model->SUPPLIER_DESC = $item->SUPPLIER_DESC;
    	$model->UM = $item->UM;
    	$model->QTY = $item->NILAI_INVENTORY;
    	$model->EXPIRED_DATE = date('Y-m-d', strtotime($item->EXPIRED_DATE));
    	$model->LATEST_EXPIRED_DATE = date('Y-m-d', strtotime($max_expired_date->EXPIRED_DATE));
    	$model->USER_ID = $tmp_user->NIK_SUN_FISH;
    	$model->USER_DESC = $tmp_user->NAMA_KARYAWAN;
    	$model->USER_LAST_UPDATE = $last_update;

    	try {
			if ($model->load($_POST) && $model->save()) {
				$item->SCRAP_REQUEST_STATUS = 1;
				if (!$item->save()) {
					return json_encode($item->errors);
				}
				//$this->sendScrapRequestEmail($model->SERIAL_NO);
				return $this->redirect(['/scrap-request']);

			} elseif (!\Yii::$app->request->isPost) {
				$model->load($_GET);
			}
		} catch (\Exception $e) {
			$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
			$model->addError('_exception', $msg);
		}

		return $this->render('scrap', [
			'model' => $model
		]);
	}

	public function sendScrapRequestEmail($SERIAL_NO)
	{
		$trace_item_dtr = TraceItemScrap::find()->where(['SERIAL_NO' => $SERIAL_NO])->one();
		$msg = '
        Please confirm the following scrap request (Link ' . Html::a('HERE', 'http://10.110.52.5:86/scrap-request?SERIAL_NO=' . $SERIAL_NO) . '):
        <ul>
            <li>Part No. : ' . $trace_item_dtr->ITEM . '</li>
            <li>Part Name : ' . $trace_item_dtr->ITEM_DESC . '</li>
            <li>Supplier : ' . $trace_item_dtr->SUPPLIER_DESC . '</li>
            <li>Qty : ' . $trace_item_dtr->QTY . '</li>
            <li>UM : ' . $trace_item_dtr->UM . '</li>
            <li>Request Expired Date (minimum) : ' . date('Y-m-d', strtotime($trace_item_dtr->LATEST_EXPIRED_DATE)) . '</li>
            <li>Requestor ID : ' . $trace_item_dtr->USER_ID . '</li>
            <li>Requestor Name : ' . $trace_item_dtr->USER_DESC . '</li>
        </ul>
        <br/>
        Thanks & Best Regards,<br/>
        MITA
        ';

        \Yii::$app->mailer2->compose(['html' => '@app/mail/layouts/html'], [
            'content' => $msg
        ])
        ->setFrom(['yemi.pch@gmail.com' => 'YEMI - MIS'])
        ->setTo(['frenky.purnama@music.yamaha.com'/*, 'angga.adhitya@music.yamaha.com','fredy.agus@music.yamaha.com'*/])
        //->setCc($set_to_cc_arr)
        ->setSubject('Scrap Request')
        ->send();
	}
}
