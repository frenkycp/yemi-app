<?php

namespace app\controllers;

use app\models\Karyawan;
use app\models\TraceItemDtr;
use app\models\TraceItemScrap;
use yii\helpers\Url;
use yii\helpers\Html;

class ExpiredItemController extends \app\controllers\base\ExpiredItemController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
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
				$this->sendScrapRequestEmail($model->SERIAL_NO);
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
        ->setTo(['frenky.purnama@music.yamaha.com', 'angga.adhitya@music.yamaha.com','fredy.agus@music.yamaha.com'])
        //->setCc($set_to_cc_arr)
        ->setSubject('Scrap Request')
        ->send();
	}
}
