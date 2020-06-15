<?php
namespace app\controllers;

use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use app\models\SernoInput;
use app\models\SernoInputAll;
use app\models\ProdNgData;
use app\models\ProdNgRatio;
use app\models\SernoInputPlan;
use app\models\SernoOutput;
use app\models\DailyProductionOutput;
use app\models\IjazahPlanActual;
use app\models\FiscalTbl;
use app\models\SernoMaster;

class ProductionRestController extends Controller
{
    public function getPeriodArr($post_date='')
    {
        if ($post_date == '') {
            $current_period = date('Ym');
        } else {
            $current_period = date('Ym', strtotime($post_date));
        }

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => $current_period
        ])->one();

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $current_fiscal->FISCAL
        ])
        ->andWhere(['<=', 'PERIOD', $current_period])
        ->orderBy('PERIOD')
        ->all();

        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        return $period_arr;
    }

    public function actionIjazahUpdateLine()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $tmp_ijazah = IjazahPlanActual::find()
        ->select('ITEM, LINE')
        //->where('LINE IS NULL')
        ->groupBy('ITEM, LINE')
        ->all();

        $tmp_item = [];
        foreach ($tmp_ijazah as $key => $value) {
            $tmp_item[] = $value->ITEM;
        }

        $tmp_serno_master = SernoMaster::find()
        ->where([
            'gmc' => $tmp_item
        ])
        ->all();

        $count = 0;
        foreach ($tmp_serno_master as $serno_master) {
            foreach ($tmp_ijazah as $ijazah) {
                if ($serno_master->gmc == $ijazah->ITEM && $serno_master->line != $ijazah->LINE) {
                    IjazahPlanActual::updateAll(['LINE' => $value->line, 'LINE_LAST_UPDATE' => $this_time], ['ITEM' => $value->gmc]);
                    $count++;
                }
            }
        }

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);

        return 'Update Success...(' . $count . '/' . count($tmp_item) . ') - ' . $total_minutes . ' minute(s)';
    }

    public function actionIjazahAlloc($post_date='')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $period_arr = $this->getPeriodArr($period_arr);

        $tmp_ijazah_arr = IjazahPlanActual::find()
        ->where([
            'PERIOD' => $period_arr
        ])
        ->orderBy('ITEM, PERIOD')
        ->all();

        $tmp_total_actual_arr = IjazahPlanActual::find()
        ->select([
            'ITEM', 'ACTUAL_QTY' => 'SUM(ACTUAL_QTY)'
        ])
        ->where([
            'PERIOD' => $period_arr
        ])
        ->andWhere(['>', 'ACTUAL_QTY', 0])
        ->groupBy('ITEM')
        ->all();

        $data_update = 0;
        foreach ($tmp_total_actual_arr as $tmp_total_actual) {
            $total_alloc = $tmp_total_actual->ACTUAL_QTY;
            foreach ($tmp_ijazah_arr as $tmp_ijazah) {
                if ($tmp_total_actual->ITEM == $tmp_ijazah->ITEM) {
                    $tmp_period = $tmp_ijazah->PERIOD;
                    $plan_qty = $tmp_ijazah->PLAN_QTY;
                    if ($total_alloc > $plan_qty) {
                        $actual_qty_alloc = $plan_qty;
                        $total_alloc -= $plan_qty;
                    } else {
                        $actual_qty_alloc = $total_alloc;
                        $total_alloc = 0;
                    }

                    if ($actual_qty_alloc != $tmp_ijazah->ACTUAL_QTY_ALLOC) {
                        $update_ijazah = IjazahPlanActual::findOne($tmp_ijazah->ITEM . '-' . $tmp_ijazah->PERIOD);
                        $update_ijazah->ACTUAL_QTY_ALLOC = $actual_qty_alloc;
                        $update_ijazah->BALANCE_QTY_ALLOC = $plan_qty - $actual_qty_alloc;
                        $update_ijazah->ACT_ALLOC_LAST_UPDATE = $this_time;
                        if (!$update_ijazah->save()) {
                            return $update_ijazah->errors;
                        }
                        $data_update++;
                    }
                    
                }
            }
        }
        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);
        return 'Update ' . $data_update . ' data(s) Success...(' . $total_minutes . ' minute(s))';
    }

    public function actionIjazahUpdateActual($post_date = '')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this_time = date('Y-m-d H:i:s');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $period = $this->getPeriodArr($period_arr);
        //return $period;

        $tmp_output = SernoOutput::find()
        ->select([
            'id' ,'gmc', 'output' => 'SUM(output)'
        ])
        ->where([
            'id' => $period
        ])
        ->andWhere(['>', 'output', 0])
        ->groupBy('id, gmc')
        ->all();

        $tmp_plan = ArrayHelper::map(IjazahPlanActual::find()->where([
            'PERIOD' => $period
        ])->all(), 'ID', 'PLAN_QTY');

        $tmp_plan2 = IjazahPlanActual::find()->where([
            'PERIOD' => $period
        ])->all();

        $insert_arr = $minus = [];
        //$insert_gmc = [];
        $bulkInsertArray = [];
        $columnNameArray = ['ID', 'PRODUCT_TYPE', 'BU', 'MODEL', 'PERIOD', 'ITEM', 'ITEM_DESC', 'DESTINATION', 'PLAN_QTY', 'ACTUAL_QTY', 'BALANCE_QTY', 'FORECAST_NAME', 'ACT_LAST_UPDATE'];
        $total_insert = $total_update = 0;
        foreach ($tmp_output as $key => $value) {
            $index = $value->gmc . '-' . $value->id;
            $found = false;
            $tmp_act_qty = 0;
            foreach ($tmp_plan2 as $plan2) {
                if ($plan2->ID == $index) {
                    $found = true;
                    $tmp_act_qty = $plan2->ACTUAL_QTY;
                    $tmp_plan_qty = $plan2->PLAN_QTY;
                }
            }
            if ($found) {
                if ($value->output != $tmp_act_qty) {
                    $balance = $tmp_plan_qty - $value->output;
                    $tmp_update = IjazahPlanActual::findOne($index);
                    $tmp_update->ACTUAL_QTY = $value->output;
                    $tmp_update->BALANCE_QTY = $balance;
                    $tmp_update->ACT_LAST_UPDATE = $this_time;
                    if (!$tmp_update->save()) {
                        return $tmp_update->errors;
                    }
                    $total_update++;
                }
            } else {
                $tmp_gmc = IjazahPlanActual::find()->where(['ITEM' => $value->gmc])->orderBy('PERIOD DESC')->one();
                $balance = 0 - $value->output;
                $tmp_insert = [
                    'ID' => $index,
                    'PRODUCT_TYPE' => $tmp_gmc->PRODUCT_TYPE,
                    'BU' => $tmp_gmc->BU,
                    'MODEL' => $tmp_gmc->MODEL,
                    'PERIOD' => $value->id,
                    'ITEM' => $value->gmc,
                    'ITEM_DESC' => $tmp_gmc->ITEM_DESC,
                    'DESTINATION' => $tmp_gmc->DESTINATION,
                    'PLAN_QTY' => 0,
                    'ACTUAL_QTY' => $value->output,
                    'BALANCE_QTY' => $balance,
                    'FORECAST_NAME' => 'WAIT',
                    'ACT_LAST_UPDATE' => $this_time
                ];
                $bulkInsertArray[] = [
                    $tmp_insert['ID'], $tmp_insert['PRODUCT_TYPE'], $tmp_insert['BU'], $tmp_insert['MODEL'], $tmp_insert['PERIOD'], $tmp_insert['ITEM'], $tmp_insert['ITEM_DESC'], $tmp_insert['DESTINATION'], $tmp_insert['PLAN_QTY'], $tmp_insert['ACTUAL_QTY'], $tmp_insert['BALANCE_QTY'], $tmp_insert['FORECAST_NAME'], $tmp_insert['ACT_LAST_UPDATE']
                ];
            }
            /*if (isset($tmp_plan[$index])) {
                $balance = $tmp_plan[$index] - $value->output;
                $tmp_update = IjazahPlanActual::findOne($index);
                $tmp_update->ACTUAL_QTY = $value->output;
                $tmp_update->BALANCE_QTY = $balance;
                $tmp_update->ACT_LAST_UPDATE = $this_time;
                if (!$tmp_update->save()) {
                    return $tmp_update->errors;
                }
                $total_update++;
            } else {
                //$insert_gmc[] = $value->gmc;
                $tmp_gmc = IjazahPlanActual::find()->where(['ITEM' => $value->gmc])->orderBy('PERIOD DESC')->one();
                $balance = 0 - $value->output;
                $tmp_insert = [
                    'ID' => $index,
                    'PRODUCT_TYPE' => $tmp_gmc->PRODUCT_TYPE,
                    'BU' => $tmp_gmc->BU,
                    'MODEL' => $tmp_gmc->MODEL,
                    'PERIOD' => $value->id,
                    'ITEM' => $value->gmc,
                    'ITEM_DESC' => $tmp_gmc->ITEM_DESC,
                    'DESTINATION' => $tmp_gmc->DESTINATION,
                    'PLAN_QTY' => 0,
                    'ACTUAL_QTY' => $value->output,
                    'BALANCE_QTY' => $balance,
                    'FORECAST_NAME' => 'WAIT',
                    'ACT_LAST_UPDATE' => $this_time
                ];
                $bulkInsertArray[] = [
                    $tmp_insert['ID'], $tmp_insert['PRODUCT_TYPE'], $tmp_insert['BU'], $tmp_insert['MODEL'], $tmp_insert['PERIOD'], $tmp_insert['ITEM'], $tmp_insert['ITEM_DESC'], $tmp_insert['DESTINATION'], $tmp_insert['PLAN_QTY'], $tmp_insert['ACTUAL_QTY'], $tmp_insert['BALANCE_QTY'], $tmp_insert['FORECAST_NAME'], $tmp_insert['ACT_LAST_UPDATE']
                ];
            }*/
        }

        $total_insert = count($bulkInsertArray);
        if($total_insert > 0){
            $insertCount = \Yii::$app->db_sql_server->createCommand()
            ->batchInsert(IjazahPlanActual::getTableSchema()->fullName, $columnNameArray, $bulkInsertArray)
            ->execute();
        }

        //print_r($minus);

        $process_time = strtotime(date('Y-m-d H:i:s')) - strtotime($this_time);
        $total_minutes = round($process_time / 60, 1);
        return [
            'Total Update' => $total_update,
            'Total Insert' => $total_insert,
            'Total Time' => $total_minutes
        ];
    }

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

        $tmp_act = SernoInputAll::find()
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
                return json_encode('error bulk insert' . $e);
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
                return json_encode('error proddate : ' . $value_act->proddate . ', GMC : ' . $value_act->gmc . '. ' . $models->errors);
            }
        }

        return 'Update Success ';
    }

}