<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\StoreInOutWsus;
use app\models\IpqaPatrolTbl;
use app\models\SernoInput;

class DisplayQaController extends Controller
{
	public function actionQcKpi()
	{
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $data1 = StoreInOutWsus::find()
        ->select([
        	'ITEM', 'ITEM_DESC', 'QTY_IN' => 'SUM(QTY_IN)', 'inspect_datetime' => 'MAX(inspect_datetime)'
        ])
        ->where([
        	'TRANS_ID' => '11',
        	'CAST(LAST_UPDATE AS date)' => $today,
        	'Judgement' => 'NG'
        ])
        ->groupBy('ITEM, ITEM_DESC')
        ->orderBy('inspect_datetime DESC')
        ->limit(1)
        ->one();

        $tmp_data2 = IpqaPatrolTbl::find()
        ->where([
        	'flag' => 1,
        ])
        ->andWhere(['<>', 'status', 1])
        ->orderBy('input_datetime DESC')
        ->all();

        $data2_total = count($tmp_data2);
        $data2 = null;
        foreach ($tmp_data2 as $key => $value) {
        	if ($data2 == null) {
        		$data2 = $value;
        	}
        }

        $data3 = SernoInput::find()
        ->select([
        	'gmc' => 'tb_serno_input.gmc',
        	'description' => 'CONCAT( tb_serno_master.model, \' \', tb_serno_master.color, \' \', tb_serno_master.dest )',
        	'total_ng' => 'COUNT( qa_ng )',
        	'status' => 'IF( MAX( qa_result ) =2, \'REWORK\', \'LOTOUT\' )'
        ])
        ->leftJoin('tb_serno_master', 'tb_serno_master.gmc = tb_serno_input.gmc')
        ->where([
        	'proddate' => date('Y-m-d')
        ])
        ->andWhere('qa_ng != \'\'')
        ->orderBy('qa_ng_date DESC')
        ->one();

        return $this->render('qc-kpi', [
        	'data1' => $data1,
        	'data2' => $data2,
        	'data2_total' => $data2_total,
        	'data3' => $data3,
        ]);
	}
}