<?php
namespace app\controllers;

use yii\rest\Controller;
use app\models\SernoInput;
use app\models\ProdNgData;
use app\models\ProdNgRatio;
use app\models\SernoInputPlan;

class ProductionRestController extends Controller
{
    public function actionNgRateInsert()
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data_arr = [];
        $today = date('Y-m-d');
        $proddate = $today;
        $this_time = date('Y-m-d H:i:s');
        $tmp_serno_input = SernoInput::find()
        ->select([
            'proddate', 'line', 'gmc',
            'total' => 'COUNT(pk)'
        ])
        ->where([
            'proddate' => $proddate
        ])
        ->groupBy('proddate, line, gmc')
        ->all();

        $tmp_ng_fa = ProdNgData::find()
        ->select([
            'post_date', 'gmc_line', 'gmc_no',
            'ng_qty' => 'SUM(ng_qty)'
        ])
        ->where([
            'post_date' => $proddate
        ])
        ->groupBy('post_date, gmc_line, gmc_no')
        ->all();

        $bulkInsertArray = [];
        $columnNameArray = ['post_date', 'line', 'gmc', 'gmc_desc', 'qty_output', 'qty_ng', 'last_update'];
        $total_count = 0;

        foreach ($tmp_serno_input as $value) {
            $qty_ng = 0;
            foreach ($tmp_ng_fa as $key2 => $value2) {
                if ($value->gmc == $value2->gmc_no && $value->line == $value2->gmc_line) {
                    $qty_ng = $value2->ng_qty;
                }
            }
            $tmp_data_arr[] = [
                'proddate' => $value->proddate,
                'line' => $value->line,
                'gmc' => $value->gmc,
                'qty_output' => $value->total,
                'qty_ng' => $qty_ng
            ];
            $bulkInsertArray[] = [
                $value->proddate, $value->line, $value->gmc, $value->partName, $value->total, $qty_ng, $this_time
            ];
            $total_count++;
        }

        if ($total_count > 0) {
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(ProdNgRatio::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        return $total_count . ' data inserted';
    }

    public function actionUpdateProdSchedule($today = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data_arr = [];
        if ($today == '') {
            $today = date('Y-m-d');
        }
        

        $tmp_plan = SernoInputPlan::find()
        ->where([
            'plan' => $today
        ])
        ->all();

        $tmp_act = SernoInput::find()
        ->select([
            'line', 'gmc',
            'total' => 'COUNT(gmc)'
        ])
        ->where([
            'proddate' => $today
        ])
        ->groupBy('line, gmc')
        ->all();

        foreach ($tmp_act as $value_act) {
            $is_update = false;
            $pk_plan = '';
            foreach ($tmp_plan as $value_plan) {
                if ($value_act->line == $value_plan->line && $value_act->gmc == $value_plan->gmc) {
                    $is_update = true;
                    $pk_plan = $value_plan->pk;
                }
            }
            if ($is_update) {
                $serno_input_plan = SernoInputPlan::find()->where(['pk' => $pk_plan])->one();
                $serno_input_plan->act_qty = $value_act->total;
                $serno_input_plan->balance_qty = $serno_input_plan->act_qty - $serno_input_plan->qty;
                if (!$serno_input_plan->save()) {
                    return json_encode($serno_input_plan->errors);
                }
            }/* else {
                $tmp_pic = SernoInputPlan::find()->where([
                    '<=', 'plan', $today
                ])
                ->andWhere([
                    'line' => $value_act->line
                ])
                ->orderBy('plan DESC')
                ->one();
                $serno_input_plan = new SernoInputPlan;
                $serno_input_plan->pk = $value_act->gmc . date('Ymd');
                $serno_input_plan->nik = $tmp_pic->nik;
                $serno_input_plan->line = $value_act->line;
                $serno_input_plan->gmc = $value_act->gmc;
                $serno_input_plan->plan = date('Y-m-d 00:00:00');
                $serno_input_plan->qty = 0;
            }*/
            
        }

        return 'Finished ' . $today;
    }

}