<?php

namespace app\controllers;

use app\models\Karyawan;
use app\models\TraceItemDtr;
use app\models\TraceItemScrap;
use app\models\search\ScrapRequestSearch;

use yii\web\HttpException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

class ScrapRequestController extends \app\controllers\base\ScrapRequestController
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
	    $searchModel  = new ScrapRequestSearch;

	    if(\Yii::$app->request->get('SERIAL_NO') !== null)
	    {
	    	$searchModel->SERIAL_NO = \Yii::$app->request->get('SERIAL_NO');
	    }

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionConfirm($SERIAL_NO)
	{
		$tmp_id = \Yii::$app->user->idenetity->username;
		$tmp_user = Karyawan::find()->where([
			'OR',
			['NIK' => $tmp_id],
			['NIK_SUN_FISH' => $tmp_id]
		])->one();

		if (!$tmp_user) {
			\Yii::$app->session->setFlash('warning', 'Failed to confirm. User unregistered. Please contact administrator.');
			return $this->redirect(Url::previous());
		}

		date_default_timezone_set('Asia/Jakarta');
		$model = $this->findModel($SERIAL_NO);
		$model->STATUS = 'C';
		$model->CLOSE_BY_ID = $tmp_user->NIK_SUN_FISH;
		$model->CLOSE_BY_NAME = $tmp_user->NAMA_KARYAWAN;
		$model->CLOSE_DATETIME = date('Y-m-d H:i:s');
		if ($model->save) {
			$trace_item_dtr = TraceItemDtr::find()->where(['SERIAL_NO' => $model->SERIAL_NO])->one();
			$trace_item_dtr->SCRAP_REQUEST_STATUS = 2;
			if (!$trace_item_dtr->save()) {
				return json_encode($trace_item_dtr->errors);
			}
			//$this->confirmProcedure($model->SERIAL_NO, $model->CLOSE_BY_ID, $model->CLOSE_BY_NAME);
			$this->sendScrapConfirmEmail($model->SERIAL_NO);
			return $this->redirect(Url::previous());
		} else {
			return json_encode($model->errors);
		}
	}

	public function confirmProcedure($SERIAL_NO, $USER_ID, $USER_DESC)
	{
		$sql = "{CALL TRACE_INSERT_SERIAL_NO_ISSUE(:SERIAL_NO, :USER_ID, :USER_DESC)}";
		// passing the params into to the sql query
		$params = [
			':SERIAL_NO'=>$SERIAL_NO,
			':USER_ID'=>$USER_ID,
			':USER_DESC'=>$USER_DESC
		];
		$result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryOne();
	}

	public function sendScrapConfirmEmail($SERIAL_NO)
	{
		$trace_item_dtr = TraceItemScrap::find()->where(['SERIAL_NO' => $SERIAL_NO])->one();
		$msg = '
        The following scrap request has been confirmed. Please order as requested below :
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
        ->setTo(['frenky.purnama@music.yamaha.com;angga.adhitya@music.yamaha.com;fredy.agus@music.yamaha.com'])
        //->setCc($set_to_cc_arr)
        ->setSubject('Order Request')
        ->send();
	}
}
