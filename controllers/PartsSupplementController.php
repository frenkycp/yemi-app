<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\StoreItemWsus;
use app\models\Karyawan;
use app\models\StoreInOutWsus;

class PartsSupplementController extends Controller
{
	public function actionWhApproved($URL = '', $ITEM = 'ITEM-A', $OUT_QTY = 0, $SLIP_REF = '', $USER_ID = '', $LOC = '', $LOC_DESC = '', $NOTE)
	{
		return $this->redirect($URL);
		date_default_timezone_set("Asia/Jakarta");
		$TAG_SLIP = '000000';
		$SEQ_ID = 0;
		$NO = '000';
		$STATUS = 'SUPPLEMENT';
		$POST_DATE = date('Y-m-d H:i:s');

		$item_data = StoreItemWsus::find()
		->where([
			'ITEM' => $ITEM
		])
		->one();

		$ITEM_DESC = '';
		$UM = 'PC';
		if ($item_data->ITEM !== null) {
			$ITEM_DESC = $item_data->ITEM_DESC;
			$UM = $item_data->UM;
		} else {
			$ITEM_DESC = $ITEM;
		}

		$emp_data = Karyawan::find()
		->where([
			'NIK' => $USER_ID
		])
		->one();

		$USER_DESC = $USER_ID;
		if($emp_data->NIK !== null){
			$USER_DESC = $emp_data->NAMA_KARYAWAN;
		}

		$params = [
			':ITEM' => $ITEM,
			':ITEM_DESC' => $ITEM_DESC,
			':UM' => $UM,
			':OUT_QTY' => $OUT_QTY,
			':TAG_SLIP' => $TAG_SLIP,
			':SEQ_ID' => $SEQ_ID,
			':SLIP_REF' => $SLIP_REF,
			':NO' => $NO,
			':LOC' => $LOC,
			':LOC_DESC' => $LOC_DESC,
			':POST_DATE' => $POST_DATE,
			':USER_ID' => $USER_ID,
			':USER_DESC' => $USER_DESC,
			':STATUS' => $STATUS,
			':NOTE' => $NOTE,
		];
		$sql = "{CALL MATERIAL_OUT_INTERFACE(:ITEM, :ITEM_DESC, :UM, :OUT_QTY, :TAG_SLIP, :SEQ_ID, :SLIP_REF, :NO, :LOC, :LOC_DESC, :POST_DATE, :USER_ID, :USER_DESC, :STATUS, :NOTE)}";

		/*try {
		    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
		} catch (Exception $ex) {
			return $ex->getMessage();
		}*/
		return $this->redirect($URL);
		//return $this->redirect(Url::previous());
	}

	public function actionWhCanceled($URL = '', $USER_ID = '', $NOTE = '')
	{
		$SEQ_LOG = 0;
		$item_to_cancel = StoreInOutWsus::find()
		->where([
			'NOTE' => $NOTE
		])
		->one();

		if ($item_to_cancel->SEQ_LOG !== null) {
			$SEQ_LOG = $item_to_cancel->SEQ_LOG;
		}

		$emp_data = Karyawan::find()
		->where([
			'NIK' => $USER_ID
		])
		->one();

		$USER_DESC = $USER_ID;
		if($emp_data->NIK !== null){
			$USER_DESC = $emp_data->NAMA_KARYAWAN;
		}

		$params = [
			':SEQ_LOG' => $SEQ_LOG,
			':USER_ID' => $USER_ID,
			':USER_DESC' => $USER_DESC,
		];
		$sql = "{CALL CANCEL_SUPPLEMENT(:SEQ_LOG, :USER_ID, :USER_DESC)}";

		try {
		    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
		return $this->redirect($URL);
	}
}