<?php
namespace app\controllers;
use yii\rest\Controller;

class IncomingMaterialRestController extends Controller
{
	public function actionIndex($item = '')
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$one_month_ago = date('Y-m-d', strtotime(' -1 month'));
		

		if ($item != '') {
			$incoming = \app\models\StoreInOutWsus::find()
			// ->select([
			// 	'SEQ_LOG', 'POST_DATE', 'ITEM', 'ITEM_DESC', 'LOC', 'LOC_DESC', 'LAST_UPDATE', 'Judgement'
			// ])
			->where(['>=', 'POST_DATE', $one_month_ago])
			->andWhere([
				'TRANS_ID' => 11,
				'ITEM' => $item
			])
			->asArray()
			->all();
		} else {
			$incoming = \app\models\StoreInOutWsus::find()
			// ->select([
			// 	'SEQ_LOG', 'POST_DATE', 'ITEM', 'ITEM_DESC', 'LOC', 'LOC_DESC', 'LAST_UPDATE', 'Judgement'
			// ])
			->where(['>=', 'POST_DATE', $one_month_ago])
			->andWhere(['TRANS_ID' => 11])
			->asArray()
			->all();
		}
		return $incoming;
	}
}