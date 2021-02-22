<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\PcPiVariance;
use app\models\StoreOnhandWsus;
use app\models\FiscalTbl;
use app\models\WipOutputMonthlyView;
use app\models\WipHdrDtr;
use app\models\ProdNgData;
use app\models\DbSmtMaterialInOut;
use app\models\WhFgsStock;
use app\models\SapItemTbl;
use app\models\SernoInputAll;
use app\models\VmsItem;
use app\models\TraceItemDtr;
use app\models\TraceItemDtrLog;
use app\models\DbSmtReelInOut;
use app\models\ClientStatus;
use app\models\PcbInsertPoint;
use app\models\PcbOutputInsertPoint01;
use app\models\PcbNg01;
use app\models\TraceItemHdr;
use app\models\SapGrGiByPlant; //current stock
use app\models\SapMaterialDocumentBc; //stock in out
use app\models\IpqaPatrolTbl;
use app\models\SmtAiOutputInsertPoint01;
use app\models\SapSoPlanActual;
use app\models\SernoOutput;

class DisplayPrdController extends Controller
{
    public function actionSapVsFlo()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $this_month_period = date('Ym');
        $last_month_period = date('Ym', strtotime(' -1 month'));

        $tmp_sap_so = SapSoPlanActual::find()
        ->select([
            'period_plan',
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN quantity ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN quantity ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN quantity ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN quantity ELSE 0 END)',
        ])
        ->where(['period_plan' => [$last_month_period, $this_month_period]])
        ->andWhere(['<>', 'BU', 'OTHER'])
        ->groupBy('period_plan')
        ->all();

        $output[$last_month_period] = SernoOutput::find()->select([
            'output' => 'SUM(output)'
        ])
        ->where(['id' => $last_month_period])
        ->one();

        $output[$this_month_period] = SernoOutput::find()->select([
            'output' => 'SUM(output)'
        ])
        ->where(['id' => $this_month_period])
        ->one();

        $last_month_data = $this_month_data = [];
        foreach ($tmp_sap_so as $key => $value) {
            $total_plan = $value->total_early + $value->total_otd + $value->total_outstanding + $value->total_late;
            $total_export = $value->total_early + $value->total_otd + $value->total_late;
            $output_qty = $output[$value->period_plan]->output;
            $tmp_export_pct = $tmp_output_pct = 0;
            if ($total_plan > 0) {
                $tmp_export_pct = round(($total_export / $total_plan) * 100);
                $tmp_output_pct = round(($output[$value->period_plan]->output / $total_plan) * 100);
            }
            if ($value->period_plan == $last_month_period) {
                $last_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($last_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                ];
            } elseif ($value->period_plan == $this_month_period) {
                $this_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($this_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                ];
            }
        }

        return $this->render('sap-vs-flo', [
            'last_month_data' => $last_month_data,
            'this_month_data' => $this_month_data,
        ]);
    }

    public function actionSapSoProgress($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $this_month_period = date('Ym');
        $last_month_period = date('Ym', strtotime(' -1 month'));

        $tmp_sap_so = SapSoPlanActual::find()
        ->select([
            'period_plan',
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN quantity ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN quantity ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN quantity ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN quantity ELSE 0 END)',
        ])
        ->where(['period_plan' => [$last_month_period, $this_month_period]])
        //->andWhere(['<>', 'BU', 'OTHER'])
        ->groupBy('period_plan')
        ->all();

        $output[$last_month_period] = SernoOutput::find()->select([
            'output' => 'SUM(output)'
        ])
        ->where(['id' => $last_month_period])
        ->one();

        $output[$this_month_period] = SernoOutput::find()->select([
            'output' => 'SUM(output)'
        ])
        ->where(['id' => $this_month_period])
        ->one();

        $last_month_data = $this_month_data = [];
        foreach ($tmp_sap_so as $key => $value) {
            $total_plan = $value->total_early + $value->total_otd + $value->total_outstanding + $value->total_late;
            $total_export = $value->total_early + $value->total_otd + $value->total_late;
            $output_qty = $output[$value->period_plan]->output;
            $tmp_export_pct = $tmp_output_pct = 0;
            if ($total_plan > 0) {
                $tmp_export_pct = round(($total_export / $total_plan) * 100);
                $tmp_output_pct = round(($output[$value->period_plan]->output / $total_plan) * 100);
            }
            if ($value->period_plan == $last_month_period) {
                $last_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($last_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                ];
            } elseif ($value->period_plan == $this_month_period) {
                $this_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($this_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                ];
            }
        }

        return $this->render('sap-so-progress', [
            'last_month_data' => $last_month_data,
            'this_month_data' => $this_month_data,
        ]);
    }

    public function actionSapSoFy($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'fiscal_year'
        ]);
        $model->addRule(['fiscal_year'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        if ($_GET['fiscal'] != null) {
            $model->fiscal_year = $_GET['fiscal'];
        }

        if ($model->load($_GET)) {

        }

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal_year
        ])
        ->orderBy('PERIOD')
        ->all();
        
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $otd_arr = [
            'EARLY',
            'OTD',
            'OUTSTANDING'
        ];

        $tmp_sap_so = SapSoPlanActual::find()
        ->select([
            'period_plan',
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN quantity ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN quantity ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN quantity ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN quantity ELSE 0 END)',
        ])
        ->where(['period_plan' => $period_arr])
        ->groupBy('period_plan')
        ->all();

        $tmp_data = $categories = $data = [];
        foreach ($period_arr as $period_val) {
            $tmp_early = $tmp_otd = $tmp_outstanding = $tmp_late = 0;
            $categories[] = date('M\' Y', strtotime($period_val . '01'));
            foreach ($tmp_sap_so as $sap_so_val) {
                if ($sap_so_val->period_plan == $period_val) {
                    $tmp_early = $sap_so_val->total_early;
                    $tmp_otd = $sap_so_val->total_otd;
                    $tmp_outstanding = $sap_so_val->total_outstanding;
                    $tmp_late = $sap_so_val->total_late;
                }
            }
            $tmp_data['early'][] = [
                'y' => $tmp_early == 0 ? null : (int)$tmp_early
            ];
            $tmp_data['otd'][] = [
                'y' => $tmp_otd == 0 ? null : (int)$tmp_otd
            ];
            $tmp_data['outstanding'][] = [
                'y' => $tmp_outstanding == 0 ? null : (int)$tmp_outstanding
            ];
            $tmp_data['late'][] = [
                'y' => $tmp_late == 0 ? null : (int)$tmp_late
            ];
        }

        $data = [
            
            
            [
                'name' => 'OUTSTANDING',
                'data' => $tmp_data['outstanding'],
                'color' => 'red',
            ],
            [
                'name' => 'LATE',
                'data' => $tmp_data['late'],
                'color' => 'orange',
            ],
            [
                'name' => 'EARLY',
                'data' => $tmp_data['early'],
            ],
            [
                'name' => 'OTD',
                'data' => $tmp_data['otd'],
                'color' => 'green',
            ],
        ];

        return $this->render('sap-so-fy', [
            'model' => $model,
            'period_arr' => $period_arr,
            'data' => $data,
            'categories' => $categories,
        ]);
    }

    public function actionSmtAiInsertPoint($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'fiscal_year'
        ]);
        $model->addRule(['fiscal_year'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        if ($_GET['fiscal'] != null) {
            $model->fiscal_year = $_GET['fiscal'];
        }

        if ($model->load($_GET)) {

        }

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal_year
        ])
        ->orderBy('PERIOD')
        ->all();
        
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_total_insert = SmtAiOutputInsertPoint01::find()
        ->select([
            'child_analyst', 'end_job_period',
            'TOTAL_INSERT_POINT' => 'SUM((summary_qty * POINT_TOTAL))',
            'TOTAL_JV' => 'SUM((summary_qty * POINT_JV))',
            'TOTAL_AX' => 'SUM((summary_qty * POINT_AV))',
            'TOTAL_RH' => 'SUM((summary_qty * POINT_RG))',
        ])
        ->where([
            'end_job_period' => $period_arr,
        ])
        ->andWhere('POINT_TOTAL IS NOT NULL')
        ->groupBy('child_analyst, end_job_period')
        ->orderBy('child_analyst, end_job_period')
        ->all();

        /*$tmp_smt_total_insert = SmtAiOutputInsertPoint01::find()
        ->select([
            'end_job_period', 'TOTAL_INSERT_POINT' => 'SUM((summary_qty * POINT_TOTAL))'
        ])
        ->where([
            'end_job_period' => $period_arr,
            'child_analyst' => 'WM03'
        ])
        ->andWhere('POINT_TOTAL IS NOT NULL')
        ->groupBy('end_job_period')
        ->orderBy('end_job_period')
        ->all();

        $tmp_ai_total_insert = SmtAiOutputInsertPoint01::find()
        ->select([
            'end_job_period',
            'TOTAL_JV' => 'SUM((summary_qty * POINT_JV))',
            'TOTAL_AX' => 'SUM((summary_qty * POINT_AV))',
            'TOTAL_RH' => 'SUM((summary_qty * POINT_RG))',
        ])
        ->where([
            'end_job_period' => $period_arr,
            'child_analyst' => 'WM02'
        ])
        ->andWhere('POINT_TOTAL IS NOT NULL')
        ->groupBy('end_job_period')
        ->orderBy('end_job_period')
        ->all();*/

        return $this->render('smt-ai-insert-point', [
            'model' => $model,
            'period_arr' => $period_arr,
            'tmp_total_insert' => $tmp_total_insert,
            /*'tmp_smt_total_insert' => $tmp_smt_total_insert,
            'tmp_ai_total_insert' => $tmp_ai_total_insert,*/
        ]);
    }

    public function actionIpqaDailyPatrol()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = IpqaPatrolTbl::find()
        ->where([
            'IPQA_PATROL_TBL.flag' => 1,
            'status' => [0, 2]
        ])
        ->andWhere([
            '>=', 'event_date', '2019-12-09'
        ])
        ->orderBy('event_date DESC')
        ->all();

        return $this->render('ipqa-daily-patrol', [
            'data' => $data,
        ]);
    }

    public function actionItemCurrentStock($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $tmp_dtr = TraceItemDtr::find()
        ->select([
            'ITEM', 'ITEM_DESC', 'UM', 'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)'
        ])
        ->groupBy('ITEM, ITEM_DESC, UM')
        ->all();

        $tmp_name_arr = $item_arr = $tmp_data = $tmp_sort = [];
        foreach ($tmp_dtr as $key => $value) {
            $tmp_name_arr[$value->ITEM] = $value->ITEM_DESC;
            $tmp_data[$value->ITEM]['actual'] = $value->NILAI_INVENTORY;
            $tmp_data[$value->ITEM]['item_name'] = $value->ITEM_DESC;
            $tmp_data[$value->ITEM]['um'] = $value->UM;
            $item_arr[] = $value->ITEM;
        }

        $tmp_sap_current_stock = SapGrGiByPlant::find()->where([
            'plant' => '8250',
            'material' => $item_arr
        ])->all();

        foreach ($tmp_data as $key => $value) {
            $tmp_sap_qty = 0;
            foreach ($tmp_sap_current_stock as $sap_val) {
                if ($sap_val->material == $key) {
                    $tmp_sap_qty = $sap_val->ending_balance;
                }
            }
            $tmp_diff = $value['actual'] - $tmp_sap_qty;
            $tmp_data[$key]['sap'] = $tmp_sap_qty;
            $tmp_data[$key]['diff'] = $tmp_diff;
            $tmp_sort[$key] = $tmp_diff;
        }

        if (count($tmp_sort) > 0) {
            asort($tmp_sort);
        }

        $data = [];
        foreach ($tmp_sort as $key => $value) {
            $data[$key] = $tmp_data[$key];
        }

        return $this->render('item-current-stock', [
            'data' => $data,
        ]);
    }

    public function actionStockMonitoring($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d', strtotime('-1 day'));

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'item'
        ]);
        $model->addRule(['from_date', 'to_date', 'item'], 'required');

        $model->from_date = date('Y-m-d', strtotime($today . ' -1 month'));
        $model->to_date = $today;

        $item_arr = ArrayHelper::map(TraceItemDtr::find()->select(['ITEM', 'ITEM_DESC'])->where('ITEM IS NOT NULL')->groupBy('ITEM, ITEM_DESC')->orderBy('ITEM_DESC')->all(), 'ITEM', 'itemDescription');

        $tmp_data = $tmp_data_total = $tmp_data_sap_stock = [];
        $item_info = null;
        $current_sap = $current_actual = 0;
        if ($model->load($_GET)) {

            //start actual stock
            $model->to_date = $today;
            $tmp_dtr = TraceItemDtr::find()
            ->select([
                'LOC_DESC', 'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)'
            ])
            ->where([
                'ITEM' => $model->item
            ])
            ->groupBy('LOC_DESC')
            ->orderBy('LOC_DESC')
            ->all();

            $item_info = TraceItemHdr::find()->where(['ITEM' => $model->item])->one();

            foreach ($tmp_dtr as $dtr_val) {
                $initial_stock = $dtr_val->NILAI_INVENTORY;
                $current_actual = $initial_stock;

                $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
                $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

                $tmp_log = TraceItemDtrLog::find()
                ->select([
                    'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'LOC_DESC', 'QTY_IN' => 'ISNULL(SUM(QTY_IN), 0)', 'QTY_OUT' => 'ISNULL(SUM(QTY_OUT), 0)',
                ])
                ->where([
                    'ITEM' => $model->item,
                    'LOC_DESC' => $dtr_val->LOC_DESC
                ])
                ->andWhere(['>=', 'POST_DATE', $model->from_date])
                ->andWhere('POST_DATE IS NOT NULL')
                ->groupBy(['POST_DATE', 'LOC_DESC'])
                ->all();

                //var_dump(count($tmp_log)) ;
                if (count($tmp_log) == 0) {
                    //return 'ini yang bener?';
                    $tmp_log_last_update = TraceItemDtr::find()
                    ->select([
                        'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'NILAI_INVENTORY'
                    ])
                    ->where([
                        'ITEM' => $model->item,
                        'LOC_DESC' => $dtr_val->LOC_DESC
                    ])
                    ->andWhere(['>=', 'POST_DATE', $model->from_date])
                    ->andWhere('POST_DATE IS NOT NULL')
                    ->all();
                }

                $tmp_dtr_info = TraceItemDtr::find()
                ->select([
                    'POST_DATE' => 'CAST(POST_DATE AS DATE)'
                ])
                ->where([
                    'ITEM' => $model->item,
                    'LOC_DESC' => $dtr_val->LOC_DESC
                ])
                ->andWhere(['>=', 'POST_DATE', $model->from_date])
                ->andWhere('POST_DATE IS NOT NULL')
                ->orderBy('POST_DATE')
                ->one();

                for($i = $end; $i >= $begin; $i->modify('-1 day')){
                    $tgl = $i->format("Y-m-d");

                    $tmp_data[$dtr_val->LOC_DESC][$tgl] = $initial_stock;
                    $tmp_data_total[$tgl] += $initial_stock;

                    if (count($tmp_log) > 0) {
                        
                        foreach ($tmp_log as $log_val) {
                            //if ($tgl < $today) {
                                if ($log_val->POST_DATE == $tgl) {
                                    $initial_stock += $log_val->QTY_OUT;
                                    $initial_stock -= $log_val->QTY_IN;
                                }
                            //}
                            
                        }
                    } else {
                        //return 'hah?';
                        foreach ($tmp_log_last_update as $log_last_update) {
                            if ($log_last_update->POST_DATE == $tgl) {
                                $initial_stock -= $log_last_update->NILAI_INVENTORY;
                            }
                        }
                    }

                    if ($tgl < $tmp_dtr_info->POST_DATE) {
                        $initial_stock = 0;
                    }

                }
            } //end actual stock
            
            //start sap stock
            $tmp_sap_current_stock = SapGrGiByPlant::find()->where([
                'plant' => '8250',
                'material' => $model->item
            ])->one();
            $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
            $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));
            $sap_initial_stock = 0;
            $sap_stock_last_update = date('Y-m-d');
            if ($tmp_sap_current_stock) {
                $sap_initial_stock = $tmp_sap_current_stock->ending_balance;
                $sap_stock_last_update = date('Y-m-d', $tmp_sap_current_stock->file_date);
            }
            $current_sap = $sap_initial_stock;

            $tmp_sap_log_arr = SapMaterialDocumentBc::find()
            ->select([
                'posting_date' => 'CAST(posting_date AS date)', 'qty_in' => 'SUM(qty_in)', 'qty_out' => 'SUM(qty_out)'
            ])
            ->where([
                'plant' => '8250',
                'material' => $model->item
            ])
            ->andWhere(['>=', 'posting_date', $model->from_date])
            //->andWhere(['<=', 'posting_date', $sap_stock_last_update])
            ->groupBy('posting_date')
            ->orderBy('posting_date DESC')
            ->all();

            for($i = $end; $i >= $begin; $i->modify('-1 day')){
                $tgl = $i->format("Y-m-d");
                /*if ($tgl > $sap_stock_last_update) {
                    $tmp_data_sap_stock[$tgl] = null;
                } else {
                    $tmp_data_sap_stock[$tgl] = $sap_initial_stock;
                }*/
                $tmp_data_sap_stock[$tgl] = round($sap_initial_stock);

                foreach ($tmp_sap_log_arr as $tmp_sap_log) {
                    if ($tgl == $tmp_sap_log->posting_date) {
                        $sap_initial_stock += $tmp_sap_log->qty_out;
                        $sap_initial_stock -= $tmp_sap_log->qty_in;
                    }
                }
            }
        }

        if (count($tmp_data > 0)) {
            foreach ($tmp_data as $key => $value) {
                ksort($tmp_data[$key]);
            }
        }
        ksort($tmp_data_total);
        ksort($tmp_data_sap_stock);

        $tmp_data2 = [];
        foreach ($tmp_data as $loc_desc => $value) {
            $tmp_data3 = [];
            foreach ($value as $tgl => $value2) {
                $post_date = (strtotime($tgl . " +7 hours") * 1000);
                $tmp_data3[] = [
                    'x' => $post_date,
                    'y' => round($value2),
                ];
            }
            $tmp_data2[$loc_desc] = $tmp_data3;
        }

        $tmp_data_total2 = $tmp_data_sap_stock2 = $tmp_data_diff = [];
        foreach ($tmp_data_total as $key => $value) {
            $post_date = (strtotime($key . " +7 hours") * 1000);
            $tmp_data_total2[] = [
                'x' => $post_date,
                'y' => ($value),
            ];
            $tmp_data_sap_stock2[] = [
                'x' => $post_date,
                'y' => ($tmp_data_sap_stock[$key]),
            ];
            $tmp_diff = $value - $tmp_data_sap_stock[$key];
            $tmp_data_diff[] = $tmp_diff;
        }

        $diff_avg = 0;
        if (count($tmp_data_diff) > 0) {
            $diff_avg = array_sum($tmp_data_diff)/count($tmp_data_diff);
        }
        

        /*$tmp_data_sap_stock2 = [];
        foreach ($tmp_data_sap_stock as $key => $value) {
            $post_date = (strtotime($key . " +7 hours") * 1000);
            $tmp_data_sap_stock2[] = [
                'x' => $post_date,
                'y' => ($value),
            ];
        }*/

        $data = [];
        /*foreach ($tmp_data2 as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $value
            ];
        }*/
        $data[] = [
            'name' => 'ACTUAL QTY',
            'data' => $tmp_data_total2
        ];
        $data[] = [
            'name' => 'SAP QTY',
            'data' => $tmp_data_sap_stock2
        ];

        $current_pct = 0;
        if ($current_sap > 0) {
            $current_pct = round(($current_actual / $current_sap - 1) * 100, 1);
        } else {
            $current_pct = round((0 - 1) * 100, 1);
        }

        return $this->render('stock-monitoring', [
            'model' => $model,
            'item_arr' => $item_arr,
            'tmp_data' => $tmp_data,
            'data' => $data,
            'current_pct' => $current_pct,
            'diff_avg' => $diff_avg,
            'um' => $item_info->UM,
        ]);
    }

    public function actionPcbDefectRatio($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'fiscal_year'
        ]);
        $model->addRule(['fiscal_year'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        if ($_GET['fiscal'] != null) {
            $model->fiscal_year = $_GET['fiscal'];
        }

        if ($model->load($_GET)) {

        }

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal_year
        ])
        ->orderBy('PERIOD')
        ->all();
        
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $bu_arr = ['AV', 'PA', 'PIANO'];
        $ppm_target_arr = [
            'ALL' => 1.15,
            'AV' => 1.02,
            'PA' => 1.01
        ];
        $tmp_data = [];

        $tmp_wip_output = PcbOutputInsertPoint01::find()
        ->select([
            'end_job_period', 'bu', 'total_insert_point' => 'SUM(total_insert_point)'
        ])
        ->groupBy('end_job_period, bu')
        ->orderBy('end_job_period, bu')
        ->all();

        $tmp_ng_pcb = PcbNg01::find()
        ->select([
            'period', 'bu',
            'defect_fa' => 'SUM(CASE WHEN pcb_ng_found = \'FA\' THEN ng_qty ELSE 0 END)',
            'defect_fct_ict' => 'SUM(CASE WHEN pcb_ng_found IN (\'FCT\', \'ICT\') THEN ng_qty ELSE 0 END)',
            'defect_mi' => 'SUM(CASE WHEN pcb_process = \'MI\' THEN ng_qty ELSE 0 END)',
            'defect_ai' => 'SUM(CASE WHEN pcb_process = \'AI\' THEN ng_qty ELSE 0 END)',
            'defect_smt' => 'SUM(CASE WHEN pcb_process = \'SMT\' THEN ng_qty ELSE 0 END)',
        ])
        ->where([
            'period' => $period_arr,
        ])
        ->groupBy('period, bu')
        ->orderBy('period, bu')
        ->all();

        foreach ($bu_arr as $bu_val) {
            foreach ($period_arr as $period_value) {
                $tmp_total = 0;
                foreach ($tmp_wip_output as $key => $output) {
                    $tmp_bu = $output->bu;
                    /*if (isset(\Yii::$app->params['bu_conversion_arr'][$tmp_bu])) {
                        $tmp_bu = \Yii::$app->params['bu_conversion_arr'][$tmp_bu];
                    }*/

                    if ($tmp_bu == $bu_val && $output->end_job_period == $period_value) {
                        $tmp_total += $output->total_insert_point;
                    }
                }
                $tmp_data['ALL'][$period_value]['output'] += $tmp_total;
                $tmp_data[$bu_val][$period_value]['output'] = $tmp_total;
                
                $tmp_ng_fa = $tmp_ng_fct_ict = 0;
                $tmp_ng_mi = $tmp_ng_ai = $tmp_ng_smt = 0;
                foreach ($tmp_ng_pcb as $ng_pcb) {
                    $tmp_bu = $ng_pcb->bu;
                    /*if (isset(\Yii::$app->params['bu_conversion_arr'][$tmp_bu])) {
                        $tmp_bu = \Yii::$app->params['bu_conversion_arr'][$tmp_bu];
                    }*/
                    if ($ng_pcb->period == $period_value && $tmp_bu == $bu_val) {
                        $tmp_ng_fa = $ng_pcb->defect_fa;
                        $tmp_ng_fct_ict = $ng_pcb->defect_fct_ict;
                        $tmp_ng_mi = $ng_pcb->defect_mi;
                        $tmp_ng_ai = $ng_pcb->defect_ai;
                        $tmp_ng_smt = $ng_pcb->defect_smt;
                    }
                }

                $tmp_data['ALL'][$period_value]['defect_fa'] += $tmp_ng_fa;
                $tmp_data['ALL'][$period_value]['defect_fct_ict'] += $tmp_ng_fct_ict;
                $tmp_data['ALL'][$period_value]['defect_mi'] += $tmp_ng_mi;
                $tmp_data['ALL'][$period_value]['defect_ai'] += $tmp_ng_ai;
                $tmp_data['ALL'][$period_value]['defect_smt'] += $tmp_ng_smt;

                $tmp_data[$bu_val][$period_value]['defect_fa'] = $tmp_ng_fa;
                $tmp_data[$bu_val][$period_value]['defect_fct_ict'] = $tmp_ng_fct_ict;
                $tmp_data[$bu_val][$period_value]['defect_mi'] = $tmp_ng_mi;
                $tmp_data[$bu_val][$period_value]['defect_ai'] = $tmp_ng_ai;
                $tmp_data[$bu_val][$period_value]['defect_smt'] = $tmp_ng_smt;
            }
        }

        return $this->render('pcb-defect-ratio', [
            'model' => $model,
            'tmp_data' => $tmp_data,
            'period_arr' => $period_arr,
            'ppm_target_arr' => $ppm_target_arr,
        ]);
    }

    public function actionNetworkStatusData($value='')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this_time = date('Y-m-d H:i:s');

        $tmp_data_client = ClientStatus::find()
        ->where(['visible' => 1])
        ->all();

        $tmp_status_arr = [];
        foreach ($tmp_data_client as $key => $value) {
            $tmp_new_class = 'client-widget bg-green';
            if ($value->reply_roundtriptime > 10) {
                $tmp_new_class = 'client-widget bg-yellow';
            }

            $diff_s = strtotime($this_time) - strtotime($value->last_update);
            if ($diff_s > 60) {
                $tmp_new_class = 'client-widget bg-red';
            }

            $tmp_status_arr[$value->server_mac_address]['new_class'] = $tmp_new_class;
        }

        return $tmp_status_arr;
    }

    public function actionNetworkStatus($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = ClientStatus::find()
        ->where(['visible' => 1])
        ->all();

        return $this->render('network-status', [
            'data' => $data,
        ]);
    }

    public function actionExpirationGetLog($SERIAL_NO)
    {
        $tmp_item = TraceItemDtr::findOne($SERIAL_NO);
        $tmp_log = TraceItemDtrLog::find()->where(['SERIAL_NO' => $SERIAL_NO])->orderBy('LAST_UPDATE DESC')->all();

        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $tmp_item->ITEM_DESC . ' - ' . $tmp_item->ITEM . ' <small>(Serial No. : ' . $SERIAL_NO . ')</small></h3>
        </div>
        <div class="modal-body">
        ';

        $data .= '<table class="table table-bordered table-striped table-hover">';
        $data .= '
        <tr>
            <th class="text-center">Last Update</th>
            <th class="text-center">Transaction</th>
            <th class="text-center">Qty</th>
            <th class="text-center">UM</th>
        </tr>
        ';

        foreach ($tmp_log as $value) {
            if ($value->TRANS_ID == 'IN') {
                $tmp_trans = '<span class="label label-success">IN</span>';
                $tmp_qty = $value->QTY_IN;
            } else {
                $tmp_trans = '<span class="label label-warning">OUT</span>';
                $tmp_qty = $value->QTY_OUT;
            }
            $data .= '
            <tr>
                <td class="text-center">' . date('d M\' Y H:i', strtotime($value->LAST_UPDATE)) . '</td>
                <td class="text-center">' . $tmp_trans . '</td>
                <td class="text-center">' . $tmp_qty . '</td>
                <td class="text-center">' . $value->UM . '</td>
            </tr>
            ';
        }

        $data .= '</table>';

        return $data;
    }

    public function actionExpirationMonitoringGetRemark($post_date, $item_category, $data_category = 'expired')
    {
        if ($item_category == 'ALL') {
            $filter_arr = [
                'AVAILABLE' => 'Y',
            ];
        } else {
            [
                'AVAILABLE' => 'Y',
                'CATEGORY' => $item_category
            ];
        }

        if ($data_category == 'expired') {
            $tmp_trace_arr = TraceItemDtr::find()
            ->where([
                '<=', 'EXPIRED_DATE', $post_date
            ])
            ->andWhere($filter_arr)
            ->orderBy('EXPIRED_DATE')
            ->all();
            $tmp_title = 'Expired';
        } elseif ($data_category == 'one_month') {
            $tmp_trace_arr = TraceItemDtr::find()
            ->where([
                '<=', 'EXPIRED_DATE', date('Y-m-d', strtotime($post_date . ' +1 month'))
            ])
            ->andWhere(['>', 'EXPIRED_DATE', $post_date])
            ->andWhere($filter_arr)
            ->orderBy('EXPIRED_DATE')
            ->all();
            $tmp_title = '1 Month Before Expired';
        } else {
            $tmp_trace_arr = TraceItemDtr::find()
            ->where($filter_arr)
            ->orderBy('EXPIRED_DATE')
            ->all();
            $tmp_title = 'All Items';
        }

        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $tmp_title . ' - Category : ' . $item_category . ' <small>(' . date('d M\' Y') . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">No.</th>
            <th class="text-center">Category</th>
            <th class="text-center">Part No.</th>
            <th class="">Part Description</th>
            <th class="">Location</th>
            <th class="text-center">Qty</th>
            <th class="text-center">UM</th>
            <th class="text-center">Rcv. Date</th>
            <th class="text-center">Exp. Date</th>
        </tr>';

        $no = 1;
        foreach ($tmp_trace_arr as $tmp_trace) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' . $no . '</td>
                <td class="text-center">' . $tmp_trace->CATEGORY . '</td>
                <td class="text-center">' . $tmp_trace->ITEM . '</td>
                <td class="">' . $tmp_trace->ITEM_DESC . '</td>
                <td class="">' . $tmp_trace->LOC_DESC . '</td>
                <td class="text-center">' . $tmp_trace->NILAI_INVENTORY . '</td>
                <td class="text-center">' . $tmp_trace->UM . '</td>
                <td class="text-center">' . date('d M\' Y', strtotime($tmp_trace->RECEIVED_DATE)) . '</td>
                <td class="text-center">' . date('d M\' Y', strtotime($tmp_trace->EXPIRED_DATE)) . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionExpirationMonitoring($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime(' +1 day'));

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'item_category'
        ]);
        $model->addRule(['from_date', 'to_date', 'item_category'], 'required');

        $model->from_date = $today;
        $model->to_date = date('Y-m-t', strtotime(' +3 months'));
        $model->item_category = 'ALL';

        $item_category_arr = ArrayHelper::map(TraceItemDtr::find()->select('CATEGORY')->where('CATEGORY IS NOT NULL')->groupBy('CATEGORY')->orderBy('CATEGORY')->all(), 'CATEGORY', 'CATEGORY');
        $item_category_arr['ALL'] = '-ALL CATEGORY-';

        $tmp_data = $data = [];
        if ($model->load($_GET)) {
            
        }

        if ($model->item_category == 'ALL') {
            $tmp_trace_arr = TraceItemDtr::find()
            ->where([
                'AVAILABLE' => 'Y',
            ])
            ->orderBy('EXPIRED_DATE')
            ->all();
        } else {
            $tmp_trace_arr = TraceItemDtr::find()
            ->where([
                'AVAILABLE' => 'Y',
                'CATEGORY' => $model->item_category
            ])
            ->orderBy('EXPIRED_DATE')
            ->all();
        }

        $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
        $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date)));
        
        $expired_today = $expired_tomorrow = [
            'KG' => 0,
            'L' => 0
        ];
        $expired_um_arr = ['KG', 'L'];
        for($i = $begin; $i <= $end; $i->modify('+1 day')){

            $tgl = $i->format("Y-m-d");
            //$proddate = (strtotime($tgl . " +7 hours") * 1000);
            $post_date = (strtotime($tgl . " +7 hours") * 1000);

            $tmp_total1 = $tmp_total2 = $tmp_total3 = 0;
            foreach ($tmp_trace_arr as $tmp_trace) {
                if (strtotime($tgl . '00:00:00') >= strtotime($tmp_trace->EXPIRED_DATE)) {
                    $tmp_total3 ++;

                    foreach ($expired_today as $tmp_expired_um => $expired_um) {
                        if ($tmp_expired_um == $tmp_trace->UM && $tgl == $today) {
                            $expired_today[$tmp_expired_um] += $tmp_trace->NILAI_INVENTORY;
                        }
                        if ($tmp_expired_um == $tmp_trace->UM && $tgl == $tomorrow) {
                            $expired_tomorrow[$tmp_expired_um] += $tmp_trace->NILAI_INVENTORY;
                        }
                    }
                    
                } else {
                    if (strtotime($tgl . '00:00:00') >= strtotime($tmp_trace->EXPIRED_DATE . ' -1 month')) {
                        $tmp_total2 ++;
                    } else {
                        $tmp_total1 ++;
                    }
                    
                }
                
            }
            $tmp_data['new'][] = [
                'x' => $post_date,
                'y' => round($tmp_total1),
                'url' => Url::to(['expiration-monitoring-get-remark', 'post_date' => $tgl, 'item_category' => $model->item_category, 'data_category' => 'new_incoming'])
            ];
            $tmp_data['rev'][] = [
                'x' => $post_date,
                'y' => round($tmp_total2),
                'url' => Url::to(['expiration-monitoring-get-remark', 'post_date' => $tgl, 'item_category' => $model->item_category, 'data_category' => 'one_month'])
            ];
            $tmp_data['exp'][] = [
                'x' => $post_date,
                'y' => round($tmp_total3),
                'url' => Url::to(['expiration-monitoring-get-remark', 'post_date' => $tgl, 'item_category' => $model->item_category, 'data_category' => 'expired'])
            ];
        }

        $data = [
            [
                'name' => 'New Incoming',
                'data' => $tmp_data['new'],
                'color' => \Yii::$app->params['bg-green'],
            ],
            [
                'name' => '1 Month Before Expired',
                'data' => $tmp_data['rev'],
                'color' => \Yii::$app->params['bg-yellow'],
                'cursor' => 'pointer',
                'point' => [
                    'events' => [
                        'click' => new JsExpression("
                            function(e){
                                e.preventDefault();
                                $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                            }
                        "),
                    ]
                ]
            ],
            [
                'name' => 'Expired',
                'data' => $tmp_data['exp'],
                'color' => \Yii::$app->params['bg-red'],
                'cursor' => 'pointer',
                'point' => [
                    'events' => [
                        'click' => new JsExpression("
                            function(e){
                                e.preventDefault();
                                $('#modal').modal('show').find('.modal-content').html('<div class=\"text-center\">" . Html::img('@web/loading-01.gif', ['alt'=>'some', 'class'=>'thing']) . "</div>').load(this.options.url);
                            }
                        "),
                    ]
                ]
            ],
        ];

        return $this->render('expiration-monitoring', [
            'model' => $model,
            'data' => $data,
            'item_category_arr' => $item_category_arr,
            'tmp_trace_arr' => $tmp_trace_arr,
            'today' => $today,
            'tomorrow' => $tomorrow,
            'expired_today' => $expired_today,
            'expired_tomorrow' => $expired_tomorrow,
        ]);
    }

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

    public function actionFaDefectRatioGetRemark($post_date, $defect_category)
    {
        if ($defect_category == 'pre') {
            $defect_category_filter = ['PRE'];
            $tmp_title = 'PRE';
        } elseif ($defect_category == 'self') {
            $defect_category_filter = ['SELF'];
            $tmp_title = 'SELF';
        } elseif ($defect_category == 'post') {
            $defect_category_filter = ['POST'];
            $tmp_title = 'POST';
        } elseif ($defect_category == 'self_post') {
            $defect_category_filter = ['SELF', 'POST'];
            $tmp_title = 'SELF + POST';
        }
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>NG Detail Data <small>(Category : ' . $tmp_title . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">Date</th>
            <th class="text-center">Model</th>
            <th class="text-center">NG Qty</th>
            <th class="text-center">Root Cause</th>
            <th class="">Cause</th>
            <th class="">NG Detail</th>
        </tr>';

        if ($defect_category == 'post' || $defect_category == 'self_post') {
            $tmp_ng_arr = ProdNgData::find()
            ->where([
                'loc_id' => 'WF01',
                'post_date' => $post_date,
                'fa_area_detec' => ['SOUND', 'OQC', 'FQA'],
                'defect_category' => $defect_category_filter,
                'flag' => 1
            ])
            ->orderBy('ng_qty DESC')
            ->all();
        } else {
            $tmp_ng_arr = ProdNgData::find()
            ->where([
                'loc_id' => 'WF01',
                'post_date' => $post_date,
                'fa_area_detec' => ['SOUND', 'OQC'],
                'defect_category' => $defect_category_filter,
                'flag' => 1
            ])
            ->orderBy('ng_qty DESC')
            ->all();
        }
        

        $no = 1;
        foreach ($tmp_ng_arr as $key => $value) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' .$post_date . '</td>
                <td class="text-center">' .$value->gmc_model . '</td>
                <td class="text-center">' .$value->ng_qty . '</td>
                <td class="text-center">' .$value->ng_cause_category . '</td>
                <td class="">' .$value->ng_category_desc . ' | ' . $value->ng_category_detail . '</td>
                <td class="">' .$value->ng_detail . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionFaDefectRatio($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');
        $target = 0.04;

        if ($model->load($_GET)) {

        }

        $period_arr = $this->getPeriodArr($model->period . '01');
        $tmp_serno_input = SernoInputAll::find()
        ->select([
            'period' => 'extract(year_month FROM proddate)', 'gmc', 'total' => 'COUNT(pk)'
        ])
        ->where([
            'extract(year_month FROM proddate)' => $period_arr
        ])
        ->groupBy('period, gmc')
        ->all();

        $tmp_serno_input_daily = SernoInputAll::find()
        ->select([
            'proddate', 'total' => 'COUNT(pk)'
        ])
        ->where([
            'extract(year_month FROM proddate)' => $period_arr
        ])
        ->groupBy('proddate')
        ->all();

        $tmp_info_arr = ArrayHelper::map(VmsItem::find()
        ->select(['ITEM', 'BU'])
        ->all(), 'ITEM', 'BU');

        $data = [];
        foreach ($period_arr as $key => $period) {
            
            $total_all = $total_sn = $total_pa = $total_piano = $total_bo = $total_av = $total_dmi = $total_other = $total_null = 0;
            foreach ($tmp_serno_input as $key => $value) {
                if ($value->period == $period) {
                    $tmp_bu = null;
                    if (isset($tmp_info_arr[$value->gmc])) {
                        $tmp_bu = $tmp_info_arr[$value->gmc];
                    }
                    $total_all += $value->total;
                    if ($tmp_bu == 'SN') {
                        $total_sn += $value->total;
                    } elseif ($tmp_bu == 'PA') {
                        $total_pa += $value->total;
                    } elseif ($tmp_bu == 'PIANO') {
                        $total_piano += $value->total;
                    } elseif ($tmp_bu == 'B&O') {
                        $total_bo += $value->total;
                    } elseif ($tmp_bu == 'AV') {
                        $total_av += $value->total;
                    } elseif ($tmp_bu == 'DMI') {
                        $total_dmi += $value->total;
                    } elseif ($tmp_bu == 'OTHER') {
                        $total_other += $value->total;
                    } elseif ($tmp_bu == null) {
                        $total_null += $value->total;
                    }
                }
            }

            $output_arr = [
                'total_all' => $total_all,
                'total_sn' => $total_sn,
                'total_pa' => $total_pa,
                'total_piano' => $total_piano,
                'total_bo' => $total_bo,
                'total_av' => $total_av,
                'total_dmi' => $total_dmi,
                'total_other' => $total_other,
                'total_null' => $total_null,
            ];

            $tmp_ng_pre = ProdNgData::find()
            ->select([
                'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
                'total_ng_sn' => 'ISNULL(SUM(CASE WHEN BU = \'SN\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_pa' => 'ISNULL(SUM(CASE WHEN BU = \'PA\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_piano' => 'ISNULL(SUM(CASE WHEN BU = \'PIANO\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_bo' => 'ISNULL(SUM(CASE WHEN BU = \'B&O\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_av' => 'ISNULL(SUM(CASE WHEN BU = \'AV\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_dmi' => 'ISNULL(SUM(CASE WHEN BU = \'DMI\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_other' => 'ISNULL(SUM(CASE WHEN BU = \'OTHER\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_null' => 'ISNULL(SUM(CASE WHEN BU IS NULL THEN ng_qty ELSE 0 END), 0)',
            ])
            ->leftJoin('VMS_ITEM', 'PROD_NG_TBL.gmc_no = VMS_ITEM.ITEM')
            ->where([
                'loc_id' => 'WF01',
                'fa_area_detec' => ['SOUND', 'OQC'],
                'period' => $period,
                'defect_category' => 'PRE',
                'flag' => 1,
            ])
            ->one();

            $tmp_ng_self = ProdNgData::find()
            ->select([
                'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
                'total_ng_sn' => 'ISNULL(SUM(CASE WHEN BU = \'SN\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_pa' => 'ISNULL(SUM(CASE WHEN BU = \'PA\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_piano' => 'ISNULL(SUM(CASE WHEN BU = \'PIANO\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_bo' => 'ISNULL(SUM(CASE WHEN BU = \'B&O\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_av' => 'ISNULL(SUM(CASE WHEN BU = \'AV\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_dmi' => 'ISNULL(SUM(CASE WHEN BU = \'DMI\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_other' => 'ISNULL(SUM(CASE WHEN BU = \'OTHER\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_null' => 'ISNULL(SUM(CASE WHEN BU IS NULL THEN ng_qty ELSE 0 END), 0)',
            ])
            ->leftJoin('VMS_ITEM', 'PROD_NG_TBL.gmc_no = VMS_ITEM.ITEM')
            ->where([
                'loc_id' => 'WF01',
                'fa_area_detec' => ['SOUND', 'OQC'],
                'period' => $period,
                'defect_category' => 'SELF',
                'flag' => 1,
            ])
            ->one();

            $tmp_ng_post = ProdNgData::find()
            ->select([
                'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
                'total_ng_sn' => 'ISNULL(SUM(CASE WHEN BU = \'SN\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_pa' => 'ISNULL(SUM(CASE WHEN BU = \'PA\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_piano' => 'ISNULL(SUM(CASE WHEN BU = \'PIANO\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_bo' => 'ISNULL(SUM(CASE WHEN BU = \'B&O\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_av' => 'ISNULL(SUM(CASE WHEN BU = \'AV\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_dmi' => 'ISNULL(SUM(CASE WHEN BU = \'DMI\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_other' => 'ISNULL(SUM(CASE WHEN BU = \'OTHER\' THEN ng_qty ELSE 0 END), 0)',
                'total_ng_null' => 'ISNULL(SUM(CASE WHEN BU IS NULL THEN ng_qty ELSE 0 END), 0)',
            ])
            ->leftJoin('VMS_ITEM', 'PROD_NG_TBL.gmc_no = VMS_ITEM.ITEM')
            ->where([
                'loc_id' => 'WF01',
                'fa_area_detec' => ['SOUND', 'OQC', 'FQA'],
                'period' => $period,
                'defect_category' => 'POST',
                'flag' => 1,
            ])
            ->one();

            $data[$period] = [
                'all' => [
                    'output' => $output_arr['total_all'],
                    'ng_post' => $tmp_ng_post->total_ng_all,
                    'ng_self' => $tmp_ng_self->total_ng_all,
                    'ng_pre' => $tmp_ng_pre->total_ng_all,
                    'post_ratio' => $output_arr['total_all'] == 0 ? 0 : round(($tmp_ng_post->total_ng_all / $output_arr['total_all']) * 100, 3),
                    'self_ratio' => $output_arr['total_all'] == 0 ? 0 : round(($tmp_ng_self->total_ng_all / $output_arr['total_all']) * 100, 3),
                    'pre_ratio' => $output_arr['total_all'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_all / $output_arr['total_all']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_all'] == 0 ? 0 : round((($tmp_ng_self->total_ng_all + $tmp_ng_post->total_ng_all) / $output_arr['total_all']) * 100, 3),
                ],
                'sn' => [
                    'output' => $output_arr['total_sn'],
                    'ng_post' => $tmp_ng_post->total_ng_sn,
                    'ng_self' => $tmp_ng_self->total_ng_sn,
                    'ng_pre' => $tmp_ng_pre->total_ng_sn,
                    'post_ratio' => $output_arr['total_sn'] == 0 ? 0 : round(($tmp_ng_post->total_ng_sn / $output_arr['total_sn']) * 100, 3),
                    'self_ratio' => $output_arr['total_sn'] == 0 ? 0 : round(($tmp_ng_self->total_ng_sn / $output_arr['total_sn']) * 100, 3),
                    'pre_ratio' => $output_arr['total_sn'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_sn / $output_arr['total_sn']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_sn'] == 0 ? 0 : round((($tmp_ng_self->total_ng_sn + $tmp_ng_post->total_ng_sn) / $output_arr['total_sn']) * 100, 3),
                ],
                'pa' => [
                    'output' => $output_arr['total_pa'],
                    'ng_post' => $tmp_ng_post->total_ng_pa,
                    'ng_self' => $tmp_ng_self->total_ng_pa,
                    'ng_pre' => $tmp_ng_pre->total_ng_pa,
                    'post_ratio' => $output_arr['total_pa'] == 0 ? 0 : round(($tmp_ng_post->total_ng_pa / $output_arr['total_pa']) * 100, 3),
                    'self_ratio' => $output_arr['total_pa'] == 0 ? 0 : round(($tmp_ng_self->total_ng_pa / $output_arr['total_pa']) * 100, 3),
                    'pre_ratio' => $output_arr['total_pa'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_pa / $output_arr['total_pa']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_pa'] == 0 ? 0 : round((($tmp_ng_self->total_ng_pa + $tmp_ng_post->total_ng_pa) / $output_arr['total_pa']) * 100, 3),
                ],
                'piano' => [
                    'output' => $output_arr['total_piano'],
                    'ng_post' => $tmp_ng_post->total_ng_piano,
                    'ng_self' => $tmp_ng_self->total_ng_piano,
                    'ng_pre' => $tmp_ng_pre->total_ng_piano,
                    'post_ratio' => $output_arr['total_piano'] == 0 ? 0 : round(($tmp_ng_post->total_ng_piano / $output_arr['total_piano']) * 100, 3),
                    'self_ratio' => $output_arr['total_piano'] == 0 ? 0 : round(($tmp_ng_self->total_ng_piano / $output_arr['total_piano']) * 100, 3),
                    'pre_ratio' => $output_arr['total_piano'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_piano / $output_arr['total_piano']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_piano'] == 0 ? 0 : round((($tmp_ng_self->total_ng_piano + $tmp_ng_post->total_ng_piano) / $output_arr['total_piano']) * 100, 3),
                ],
                'bo' => [
                    'output' => $output_arr['total_bo'],
                    'ng_post' => $tmp_ng_post->total_ng_bo,
                    'ng_self' => $tmp_ng_self->total_ng_bo,
                    'ng_pre' => $tmp_ng_pre->total_ng_bo,
                    'post_ratio' => $output_arr['total_bo'] == 0 ? 0 : round(($tmp_ng_post->total_ng_bo / $output_arr['total_bo']) * 100, 3),
                    'self_ratio' => $output_arr['total_bo'] == 0 ? 0 : round(($tmp_ng_self->total_ng_bo / $output_arr['total_bo']) * 100, 3),
                    'pre_ratio' => $output_arr['total_bo'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_bo / $output_arr['total_bo']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_bo'] == 0 ? 0 : round((($tmp_ng_self->total_ng_bo + $tmp_ng_post->total_ng_bo) / $output_arr['total_bo']) * 100, 3),
                ],
                'av' => [
                    'output' => $output_arr['total_av'],
                    'ng_post' => $tmp_ng_post->total_ng_av,
                    'ng_self' => $tmp_ng_self->total_ng_av,
                    'ng_pre' => $tmp_ng_pre->total_ng_av,
                    'post_ratio' => $output_arr['total_av'] == 0 ? 0 : round(($tmp_ng_post->total_ng_av / $output_arr['total_av']) * 100, 3),
                    'self_ratio' => $output_arr['total_av'] == 0 ? 0 : round(($tmp_ng_self->total_ng_av / $output_arr['total_av']) * 100, 3),
                    'pre_ratio' => $output_arr['total_av'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_av / $output_arr['total_av']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_av'] == 0 ? 0 : round((($tmp_ng_self->total_ng_av + $tmp_ng_post->total_ng_av) / $output_arr['total_av']) * 100, 3),
                ],
                'dmi' => [
                    'output' => $output_arr['total_dmi'],
                    'ng_post' => $tmp_ng_post->total_ng_dmi,
                    'ng_self' => $tmp_ng_self->total_ng_dmi,
                    'ng_pre' => $tmp_ng_pre->total_ng_dmi,
                    'post_ratio' => $output_arr['total_dmi'] == 0 ? 0 : round(($tmp_ng_post->total_ng_dmi / $output_arr['total_dmi']) * 100, 3),
                    'self_ratio' => $output_arr['total_dmi'] == 0 ? 0 : round(($tmp_ng_self->total_ng_dmi / $output_arr['total_dmi']) * 100, 3),
                    'pre_ratio' => $output_arr['total_dmi'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_dmi / $output_arr['total_dmi']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_dmi'] == 0 ? 0 : round((($tmp_ng_self->total_ng_dmi + $tmp_ng_post->total_ng_dmi) / $output_arr['total_dmi']) * 100, 3),
                ],
                'other' => [
                    'output' => $output_arr['total_other'],
                    'ng_post' => $tmp_ng_post->total_ng_other,
                    'ng_self' => $tmp_ng_self->total_ng_other,
                    'ng_pre' => $tmp_ng_pre->total_ng_other,
                    'post_ratio' => $output_arr['total_other'] == 0 ? 0 : round(($tmp_ng_post->total_ng_other / $output_arr['total_other']) * 100, 3),
                    'self_ratio' => $output_arr['total_other'] == 0 ? 0 : round(($tmp_ng_self->total_ng_other / $output_arr['total_other']) * 100, 3),
                    'pre_ratio' => $output_arr['total_other'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_other / $output_arr['total_other']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_other'] == 0 ? 0 : round((($tmp_ng_self->total_ng_other + $tmp_ng_post->total_ng_other) / $output_arr['total_other']) * 100, 3),
                ],
                'null' => [
                    'output' => $output_arr['total_null'],
                    'ng_post' => $tmp_ng_post->total_ng_null,
                    'ng_self' => $tmp_ng_self->total_ng_null,
                    'ng_pre' => $tmp_ng_pre->total_ng_null,
                    'post_ratio' => $output_arr['total_null'] == 0 ? 0 : round(($tmp_ng_post->total_ng_null / $output_arr['total_null']) * 100, 3),
                    'self_ratio' => $output_arr['total_null'] == 0 ? 0 : round(($tmp_ng_self->total_ng_null / $output_arr['total_null']) * 100, 3),
                    'pre_ratio' => $output_arr['total_null'] == 0 ? 0 : round(($tmp_ng_pre->total_ng_null / $output_arr['total_null']) * 100, 3),
                    'self_post_ratio' => $output_arr['total_null'] == 0 ? 0 : round((($tmp_ng_self->total_ng_null + $tmp_ng_post->total_ng_null) / $output_arr['total_null']) * 100, 3),
                ],
                /*'output_arr' => $output_arr,
                'ng_post' => $tmp_ng_post,
                'ng_self' => $tmp_ng_self,
                'ng_pre' => $tmp_ng_pre,*/
            ];
        }

        $tmp_daily_ng_pre = ProdNgData::find()
        ->select([
            'post_date',
            'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
        ])
        ->where([
            'loc_id' => 'WF01',
            'fa_area_detec' => ['SOUND', 'OQC'],
            'period' => $period,
            'defect_category' => 'PRE',
            'flag' => 1,
        ])
        ->groupBy('post_date')
        ->orderBy('post_date')
        ->all();

        $tmp_daily_ng_self = ProdNgData::find()
        ->select([
            'post_date',
            'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
        ])
        ->where([
            'loc_id' => 'WF01',
            'fa_area_detec' => ['SOUND', 'OQC'],
            'period' => $period,
            'defect_category' => 'SELF',
            'flag' => 1,
        ])
        ->groupBy('post_date')
        ->orderBy('post_date')
        ->all();

        $tmp_daily_ng_post = ProdNgData::find()
        ->select([
            'post_date',
            'total_ng_all' => 'ISNULL(SUM(ng_qty), 0)',
        ])
        ->where([
            'loc_id' => 'WF01',
            'fa_area_detec' => ['SOUND', 'OQC', 'FQA'],
            'period' => $period,
            'defect_category' => 'POST',
            'flag' => 1,
        ])
        ->groupBy('post_date')
        ->orderBy('post_date')
        ->all();

        $begin = new \DateTime(date('Y-m-01', strtotime($model->period . '01')));
        $end   = new \DateTime(date('Y-m-t', strtotime($model->period . '01')));
        $total_acc = 0;
        $tmp_daily_ratio_pre = $tmp_daily_ratio_post = $tmp_daily_ratio_self = $tmp_daily_ratio_self_post = $data_daily_ratio = $data_table_daily_ratio = [];
        for($i = $begin; $i <= $end; $i->modify('+1 day')){

            $tgl = $i->format("Y-m-d");
            //$proddate = (strtotime($tgl . " +7 hours") * 1000);
            $post_date = (strtotime($tgl . " +7 hours") * 1000);
            $total_all = 0;
            foreach ($tmp_serno_input_daily as $key => $value) {
                if ($value->proddate == $tgl) {
                    $total_all = $value->total;
                }
            }
            $total_acc += $total_all;

            $total_ng_all = $total_ng_sn = $total_ng_pa = $total_ng_piano = $total_ng_bo = $total_ng_av = $total_ng_dmi = $total_ng_other = $total_ng_null = 0;
            $all_ng_pre = $all_ng_self = $all_ng_post = 0;
            if ($tmp_daily_ng_self) {
                foreach ($tmp_daily_ng_self as $key => $value) {
                    if ($value->post_date == $tgl) {
                        $all_ng_self = $value->total_ng_all;
                    }
                }
            }
            
            if ($tmp_daily_ng_pre) {
                foreach ($tmp_daily_ng_pre as $key => $value) {
                    if ($value->post_date == $tgl) {
                        $all_ng_pre = $value->total_ng_all;
                    }
                }
            }
            
            if ($tmp_daily_ng_post) {
                foreach ($tmp_daily_ng_post as $key => $value) {
                    if ($value->post_date == $tgl) {
                        $all_ng_post = $value->total_ng_all;
                    }
                }
            }

            $pre_ratio = $total_all == 0 ? 0 : round(($all_ng_pre / $total_all) * 100, 3);
            $self_ratio = $total_all == 0 ? 0 : round(($all_ng_self / $total_all) * 100, 3);
            $post_ratio = $total_all == 0 ? 0 : round(($all_ng_post / $total_all) * 100, 3);
            $self_post_ratio = $total_all == 0 ? 0 : round((($all_ng_post + $all_ng_self) / $total_all) * 100, 3);

            $data_table_daily_ratio[$tgl] = [
                'all' => $total_all,
                'ng_pre' => $all_ng_pre,
                'ng_self' => $all_ng_self,
                'ng_post' => $all_ng_post,
                'ng_self_post' => $all_ng_post + $all_ng_self,
                'pre_ratio' => $pre_ratio,
                'self_ratio' => $self_ratio,
                'post_ratio' => $post_ratio,
                'self_post_ratio' => $self_post_ratio,
            ];

            $tmp_daily_ratio_pre[] = [
                'x' => $post_date,
                'y' => $pre_ratio,
                'url' => Url::to(['fa-defect-ratio-get-remark', 'post_date' => $tgl, 'defect_category' => 'pre'])
            ];
            $tmp_daily_ratio_self[] = [
                'x' => $post_date,
                'y' => $self_ratio,
                'url' => Url::to(['fa-defect-ratio-get-remark', 'post_date' => $tgl, 'defect_category' => 'self'])
            ];
            $tmp_daily_ratio_post[] = [
                'x' => $post_date,
                'y' => $post_ratio,
                'url' => Url::to(['fa-defect-ratio-get-remark', 'post_date' => $tgl, 'defect_category' => 'post'])
            ];
            $tmp_daily_ratio_self_post[] = [
                'x' => $post_date,
                'y' => $self_post_ratio,
                'url' => Url::to(['fa-defect-ratio-get-remark', 'post_date' => $tgl, 'defect_category' => 'self_post'])
            ];
            
            /*$tmp_daily_ratio[$tgl] = [
                'output' => $total_all,
                'ng_post' => $all_ng_post,
                'ng_self' => $all_ng_self,
                'ng_pre' => $all_ng_pre,
                'post_ratio' => $total_all == 0 ? 0 : round(($all_ng_post / $total_all) * 100, 3),
                'self_ratio' => $total_all == 0 ? 0 : round(($all_ng_self / $total_all) * 100, 3),
                'pre_ratio' => $total_all == 0 ? 0 : round(($all_ng_pre / $total_all) * 100, 3),
                'output_acc' => $total_acc
            ];*/
        }

        $data_daily_ratio = [
            [
                'name' => 'DEFECT RATIO (PRE)',
                'data' => $tmp_daily_ratio_pre
            ],
            [
                'name' => 'DEFECT RATIO (SELF)',
                'data' => $tmp_daily_ratio_self
            ],
            [
                'name' => 'DEFECT RATIO (POST)',
                'data' => $tmp_daily_ratio_post
            ],
            [
                'name' => 'DEFECT RATIO (SELF + POST)',
                'data' => $tmp_daily_ratio_self_post
            ],
        ];

        return $this->render('fa-defect-ratio', [
            'model' => $model,
            'data' => $data,
            'data_table_daily_ratio' => $data_table_daily_ratio,
            'data_daily_ratio' => $data_daily_ratio,
            'target' => $target,
            'period_arr' => $period_arr,
        ]);
    }

    public function actionWhFgsStockDetail($etd)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>FGS Stock <small>(' . $etd . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">GMC</th>
            <th class="text-center">GMC Desc</th>
            <th class="text-center">Total Amount</th>
        </tr>';
        
        $tmp_total_amount = WhFgsStock::find()
        ->select([
            'gmc', 'gmc_desc', 'total_output' => 'SUM(total_output)'
        ])
        ->where(['etd' => $etd])
        ->groupBy('gmc, gmc_desc')
        ->all();

        $tmp_gmc_desc = $tmp_gmc_arr = $tmp_amount_arr = [];
        foreach ($tmp_total_amount as $key => $value) {
            $tmp_gmc_desc[$value->gmc] = $value->gmc_desc;
            if (!isset($tmp_gmc_arr[$value->gmc])) {
                $tmp_gmc_arr[] = $value->gmc;
            }
        }

        $tmp_std_price = ArrayHelper::map(SapItemTbl::find()
        ->select(['material', 'standard_price'])
        ->where(['material' => $tmp_gmc_arr])
        ->all(), 'material', 'standard_price');

        $tmp_data1 = $tmp_data2 = [];
        foreach ($tmp_total_amount as $key => $value) {
            $subtotal = 0;
            if (isset($tmp_std_price[$value['gmc']])) {
                $subtotal = $value->total_output * $tmp_std_price[$value['gmc']];
            }
            $tmp_data1[$value->gmc] = $subtotal;
        }

        arsort($tmp_data1);

        foreach ($tmp_data1 as $key => $value) {
            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center">' . $key . '</td>
                <td class="text-center">' . $tmp_gmc_desc[$key] . '</td>
                <td class="text-center">' . number_format($value) . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionWhFgsStock($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $tmp_stock_arr = WhFgsStock::find()->orderBy('etd')->all();
        $tmp_data = $tmp_sort_arr = $tmp_gmc_arr = [];
        foreach ($tmp_stock_arr as $key => $value) {
            if (!isset($tmp_gmc_arr[$value->gmc])) {
                $tmp_gmc_arr[] = $value->gmc;
            }
        }

        $tmp_std_price = ArrayHelper::map(SapItemTbl::find()
        ->select(['material', 'standard_price'])
        ->where(['material' => $tmp_gmc_arr])
        ->all(), 'material', 'standard_price');

        $tmp_data_etd = [];
        foreach ($tmp_stock_arr as $key => $value) {
            if (!isset($tmp_data[$value->dst])) {
                $tmp_data[$value->dst] = 0;
            }
            if (!isset($tmp_data_etd[$value->etd])) {
                $tmp_data_etd[$value->etd] = 0;
            }
            $subtotal = 0;
            if (isset($tmp_std_price[$value->gmc])) {
                $subtotal = $value->total_output * $tmp_std_price[$value->gmc];
            }
            $tmp_data[$value->dst] += $subtotal;
            $tmp_data_etd[$value->etd] += $subtotal;
        }

        $tmp_data_etd2 = [];
        foreach ($tmp_data_etd as $key => $value) {
            $post_date = (strtotime($key . " +7 hours") * 1000);
            $tmp_data_etd2[] = [
                'x' => $post_date,
                'y' => round($value),
                'url' => Url::to(['wh-fgs-stock-detail', 'etd' => $key]),
            ];
        }

        $data_by_etd = [
            [
                'name' => 'Total Amount by ETD',
                'data' => $tmp_data_etd2
            ],
        ];

        arsort($tmp_data);
        $tmp_data_dst = $dst_category = [];
        foreach ($tmp_data as $key => $value) {
            $dst_category[] = $key;
            $tmp_data_dst[] = [
                'y' => round($value)
            ];
        }

        $data_by_dst = [
            [
                'name' => 'Total Amount',
                'data' => $tmp_data_dst,
                'showInLegend' => false
            ],
        ];

        return $this->render('wh-fgs-stock', [
            'data_by_dst' => $data_by_dst,
            'data_by_etd' => $data_by_etd,
            'dst_category' => $dst_category,
        ]);
    }

    public function actionDailySmtReel($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_in_out = DbSmtMaterialInOut::find()
        ->select([
            'post_date' => 'DATE(tgl)',
            'total_count' => 'COUNT(id_part)'
        ])
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date . ' 00:00:00'],
            ['<=', 'tgl', $model->to_date . ' 23:59:59']
        ])
        ->andWhere(['RIGHT(pk,2)' => '_0'])
        ->andWhere(['!=', 'id_part', ''])
        ->groupBy(['DATE(tgl)'])
        ->orderBy('post_date')
        ->all();

        foreach ($tmp_in_out as $key => $value) {
            $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
            $tmp_data[] = [
                'x' => $post_date,
                'y' => (int)$value->total_count,
            ];
        }

        $data = [
            [
                'name' => 'Total Count',
                'data' => $tmp_data
            ],
        ];

        return $this->render('daily-smt-reel', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionDailyMountCountingMaterial($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_in_out = DbSmtReelInOut::find()
        ->select([
            'post_date' => 'DATE(date)',
            'total_count' => 'COUNT(date)'
        ])
        ->where([
            'AND',
            ['>=', 'date', $model->from_date . ' 00:00:00'],
            ['<=', 'date', $model->to_date . ' 23:59:59']
        ])
        ->groupBy(['DATE(date)'])
        ->orderBy('post_date')
        ->all();

        foreach ($tmp_in_out as $key => $value) {
            $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
            $tmp_data[] = [
                'x' => $post_date,
                'y' => (int)$value->total_count,
            ];
        }

        $data = [
            [
                'name' => 'Total Count',
                'data' => $tmp_data
            ],
        ];

        return $this->render('daily-mount-counting-material', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionWipNgRateGetRemark($child_analyst, $period, $total_output)
    {
        $location = \Yii::$app->params['ng_rate_location_arr'][$child_analyst];
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3><u>' . $location . ' <small>(' . $period . ')</small></u><br/>Total Output : ' . number_format($total_output) . '</h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center" style="min-width: 90px;">Date</th>
            <th class="">Model</th>
            <th class="text-center">NG Qty</th>
            <th class="text-center">Root Cause</th>
            <th class="text-center">NG Category</th>
            <th class="text-center">NG Category Detail</th>
            <th class="">Remark</th>
        </tr>';

        if ($child_analyst == 'INJ') {
            $child_analyst = ['WI01', 'WI02', 'WI03'];
        }

        $tmp_ng_arr = ProdNgData::find()
        ->where([
            'loc_id' => $child_analyst,
            'period' => $period,
            'flag' => 1
        ])
        ->andWhere(['>', 'ng_qty', 0])
        ->orderBy('post_date')
        ->all();

        $no = 1;
        foreach ($tmp_ng_arr as $key => $value) {
            if ($value->part_no == null) {
                $part_no = $value->part_no;
                $part_desc = $value->part_desc;
            } else {
                $part_no = $value->pcb_id;
                $part_desc = $value->pcb_name;
            }
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' .$value->post_date . '</td>
                <td class="">' .$value->gmc_desc . '</td>
                <td class="text-center">' .$value->ng_qty . '</td>
                <td class="text-center">' .$value->ng_cause_category . '</td>
                <td class="text-center">' .$value->ng_category_desc . '</td>
                <td class="text-center">' .$value->ng_category_detail . '</td>
                <td class="">' .$value->ng_detail . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

	public function actionWipNgRate()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $data = [];

        $model = new \yii\base\DynamicModel([
            'fiscal', 'location'
        ]);
        $model->addRule(['fiscal', 'location'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal = $current_fiscal->FISCAL;

        $output_tbl_arr = $ng_tbl_arr = [];
        $period_arr = [];
        if ($model->load($_GET)) {
            $tmp_fiscal_period = FiscalTbl::find()
            ->where([
                'FISCAL' => $model->fiscal
            ])
            ->orderBy('PERIOD')
            ->all();
            
            foreach ($tmp_fiscal_period as $key => $value) {
                $period_arr[] = $value->PERIOD;
            }

            $tmp_output_monthly = WipOutputMonthlyView::find()
            ->select([
                'child_analyst_group', 'period', 'total_qty' => 'SUM(total_qty)'
            ])
            ->where([
                'child_analyst_group' => $model->location,
                //'period' => $period_arr
            ])
            ->groupBy('child_analyst_group, period')
            ->all();

            if ($model->location == 'INJ') {
                $tmp_location = ['WI01', 'WI02', 'WI03'];
            } else {
                $tmp_location = $model->location;
            }

            /*$tmp_output_monthly = WipOutputMonthlyView::find()
            ->select([
                'period', 'total_qty' => 'SUM(total_qty)'
            ])
            ->where([
                'child_analyst' => $tmp_location,
                'period' => $period_arr
            ])
            ->groupBY('period')
            ->orderBy('period')
            ->all();*/

            

            $tmp_total_ng = ProdNgData::find()
            ->select([
                'period',
                'ng_qty' => 'SUM(ng_qty)'
            ])
            ->where([
                'loc_id' => $tmp_location,
                'period' => $period_arr,
                'flag' => 1
            ])
            ->groupBy('period')
            ->orderBy('period')
            ->all();

            foreach ($period_arr as $period_val) {
                $tmp_output = $tmp_ng = 0;
                
                foreach ($tmp_total_ng as $ng_row) {
                    if ($ng_row->period == $period_val) {
                        $tmp_ng = $ng_row->ng_qty;
                    }
                }

                foreach ($tmp_output_monthly as $output_row) {
                    if ($output_row->period == $period_val && $output_row->child_analyst_group == $model->location) {
                        $tmp_output = $output_row->total_qty;
                    }
                }
                $output_tbl_arr[] = $tmp_output;
                $ng_tbl_arr[] = $tmp_ng;

                $tmp_pct = 0;
                if ($tmp_output > 0) {
                    $tmp_pct = round(($tmp_ng / $tmp_output) * 100, 3);
                }

                $tmp_data[$model->location][] = [
                    'y' => $tmp_pct,
                    'url' => Url::to(['wip-ng-rate-get-remark', 'child_analyst' => $model->location, 'period' => $period_val, 'total_output' => $tmp_output])
                ];
                /*$data[$model->location][$period_val] = [
                    'output' => $tmp_output,
                    'ng' => $tmp_ng
                ];*/
            }
        };

        

        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => \Yii::$app->params['ng_rate_location_arr'][$key],
                'data' => $value
            ];
        }

        return $this->render('wip-ng-rate', [
            'data' => $data,
            'model' => $model,
            'period_arr' => $period_arr,
            'output_tbl_arr' => $output_tbl_arr,
            'ng_tbl_arr' => $ng_tbl_arr,
        ]);
    }
}