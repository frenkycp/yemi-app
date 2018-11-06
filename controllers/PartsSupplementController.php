<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;

class PartsSupplementController extends Controller
{
	public function actionWhApproved($READY_STOCK = 0, $ITEM = 'ITEM-A', $ITEM_DESC = 'ITEM-A', $UM = 'PC', $OUT_QTY = 1, $TAG_SLIP = '000000', $SEQ_ID = 0, $SLIP_REF = '181102FA1-0001', $NO = '000', $LOC = 'WF01', $LOC_DESC = 'FINAL ASSY', $POST_DATE = '2018-11-06 15:30:00', $USER_ID = '150826', $USER_DESC = 'FRENKY CAHYA PURNAMA', $STATUS = 'SUPPLEMENT')
	{
		$response = 'WH Approved Successfull';
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
		];
		$sql = "{CALL MATERIAL_OUT(:ITEM, :ITEM_DESC, :UM, :OUT_QTY, :TAG_SLIP, :SEQ_ID, :SLIP_REF, :NO, :LOC, :LOC_DESC, :POST_DATE, :USER_ID, :USER_DESC, :STATUS)}";

		try {
		    $result = \Yii::$app->db_wsus->createCommand($sql, $params)->execute();
		} catch (Exception $ex) {
			return $ex->getMessage();
		}
		return $this->redirect(Url::previous());
	}
}