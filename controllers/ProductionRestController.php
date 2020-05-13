<?php
namespace app\controllers;

use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use app\models\SernoInput;
use app\models\ProdNgData;
use app\models\ProdNgRatio;
use app\models\SernoInputPlan;
use app\models\DailyProductionOutput;

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
        $last_update = date('Y-m-d H:i:s');

        $tmp_plan = SernoInputPlan::find()
        ->where([
            'plan' => $today
        ])
        ->all();

        $tmp_act = SernoInput::find()
        ->select([
            'gmc',
            'total' => 'COUNT(gmc)'
        ])
        ->where([
            'proddate' => $today
        ])
        ->groupBy('gmc')
        ->all();

        $arr_output = ArrayHelper::map(DailyProductionOutput::find()->where(['proddate' => $today])->all(), 'id', 'id');

        foreach ($tmp_act as $value_act) {
            $is_update = false;
            $pk_plan = '';
            
            foreach ($tmp_plan as $value_plan) {
                if ($value_act->gmc == $value_plan->gmc) {
                    $is_update = true;
                    $pk_plan = $value_plan->pk;
                }
            }
            if ($is_update) {
                $serno_input_plan = SernoInputPlan::find()->where(['pk' => $pk_plan])->one();
                $serno_input_plan->act_qty = $value_act->total;
                $serno_input_plan->balance_qty = $serno_input_plan->act_qty - $serno_input_plan->qty;
                $serno_input_plan->last_update_output = $last_update;
                if (!$serno_input_plan->save()) {
                    return json_encode($serno_input_plan->errors);
                }
            }

            $tmp_pk = $value_act->gmc . date('Ymd', strtotime($today));
            if (!isset($arr_output[$tmp_pk])) {
                $dpo = new DailyProductionOutput;
                $dpo->id = $tmp_pk;
                $dpo->period = date('Ym', strtotime($today));
                $dpo->proddate = $today;
                $dpo->gmc = $value_act->gmc;
            } else {
                $dpo = DailyProductionOutput::findOne($tmp_pk);
            }
            $dpo->last_update = $last_update;
            $dpo->act_qty = $value_act->total;
            if (!$dpo->save()) {
                return json_encode($serno_input_plan->errors);
            }
        }

        return 'Finished ' . $today;
    }

    public function actionDailyProductionUpdateMonthly($period = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($period == '') {
            $period = date('Ym');
        }
        $last_update = date('Y-m-d H:i:s');

        $tmp_act = SernoInput::find()
        ->select([
            'proddate', 'gmc',
            'total' => 'COUNT(gmc)'
        ])
        ->where([
            'EXTRACT(year_month FROM proddate)' => $period
        ])
        ->groupBy('proddate, gmc')
        ->all();

        $tmp_output = DailyProductionOutput::find()
        ->where([
            'period' => $period
        ])
        ->all();

        $tmp_plan = SernoInputPlan::find()
        ->where([
            'EXTRACT(year_month FROM plan)' => $period
        ])
        ->all();

        $arr_output = ArrayHelper::map(DailyProductionOutput::find()->where(['period' => $period])->all(), 'id', 'id');

        $bulkInsertArray = array();
        $columnNameArray = ['id', 'period', 'proddate', 'gmc', 'act_qty', 'last_update'];
        foreach ($tmp_plan as $value) {
            if (!isset($arr_output[$value->pk])) {
                $id = $value->pk;
                $period_data = date('Ym', strtotime($value->plan));
                $proddate = date('Y-m-d', strtotime($value->plan));
                $gmc = $value->gmc;
                $act_qty = 0;
                $bulkInsertArray[] = [
                    $id, $period_data, $proddate, $gmc, $act_qty, $last_update
                ];
            }
        }

        if(count($bulkInsertArray) > 0){
            try {
                $insertCount = \Yii::$app->db_mis7->createCommand()
                ->batchInsert(DailyProductionOutput::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
                ->execute();
            } catch (\Exception $e) {
                $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
                return $msg;
            }
        }

        foreach ($tmp_act as $value_act) {
            $output = DailyProductionOutput::find()->where([
                'proddate' => $value_act->proddate,
                'gmc' => $value_act->gmc
            ])->one();
            if (!$output) {
                $output = new DailyProductionOutput;
                $output->id = $value_act->gmc . date('Ymd', strtotime($value_act->proddate));
                $output->period = date('Ym', strtotime($value_act->proddate));
                $output->proddate = $value_act->proddate;
                $output->gmc = $value_act->gmc;
            }
            $output->act_qty = $value_act->total;
            $output->last_update = $last_update;
            if (!$output->save()) {
                return json_encode($models->errors);
            }
        }

        return 'Update Success ';
    }

}