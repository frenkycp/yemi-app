<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use yii\httpclient\Client;

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
use app\models\SapSoPrice;
use app\models\DataMonitoringFa;
use app\models\TraceItemDtrView;
use app\models\SapGrGiByLocLog;
use app\models\TraceItemDtrLoc;
use app\models\SensorTbl;
use app\models\InjMachineTbl;
use app\models\InjMoldingTbl;
use app\models\ShipPrdMonthlyResult;
use app\models\search\SmtOutputMonthlySearch;
use app\models\WipEffTbl;
use app\models\SmtOutputMonthlyInsertPoint02;
use app\models\PrdMonthlyeFF04;

class DisplayPrdController extends Controller
{
    public function actionPrdEff()
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

        $tmp_eff_data = PrdMonthlyeFF04::find()->where(['PERIOD' => $period_arr])->all();
        $lost_time_non_prd = $this->actionGetLostTimeNonProduction($model->fiscal_year);

        $categories = $data_table = $tmp_data_chart = $data_chart = [];
        foreach ($period_arr as $period_val) {
            $categories[] = date('M\' y', strtotime($period_val . '01'));
            $tmp_eff = $tmp_st = $tmp_wt = 0;
            foreach ($tmp_eff_data as $eff_val) {
                if ($eff_val->PERIOD == $period_val) {
                    $tmp_losstime = 0;
                    if (isset($lost_time_non_prd[$period_val])) {
                        $tmp_losstime = $lost_time_non_prd[$period_val];
                    }
                    $tmp_st = $eff_val->TOTAL_ST;
                    $tmp_wt = $eff_val->TOTAL_WT;
                    $tmp_wt -= $tmp_losstime;
                    if ($tmp_wt > 0) {
                        $tmp_eff = round($tmp_st / $tmp_wt * 100, 1);
                    }
                    $tmp_st = round( $tmp_st/ 60);
                    $tmp_wt = round($tmp_wt / 60);
                }
            }
            $tmp_data_chart[] = [
                'y' => $tmp_eff == 0 ? null : (float)$tmp_eff
            ];

            $data_table[$period_val] = [
                'st' => $tmp_st,
                'wt' => $tmp_wt,
            ];
        }

        $data_chart = [
            [
                'name' => 'Efficiency',
                'data' => $tmp_data_chart,
                'showInLegend' => false,
            ]
        ];

        return $this->render('prd-eff', [
            'model' => $model,
            'categories' => $categories,
            'period_arr' => $period_arr,
            'data_chart' => $data_chart,
            'data_table' => $data_table,
        ]);
    }

    public function actionGetLostTimeNonProduction($fiscal)
    {
        $tmp_data = null;
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('http://10.110.52.10/po/restapi/total?periode=' . $fiscal)
            ->send();
        if ($response->isOk) {
            $tmp_data = $response->getData();
        }

        $data = [];
        foreach ($tmp_data as $section_val => $value_arr) {
            foreach ($value_arr[0] as $period_val => $value) {
                if (!isset($data[$period_val])) {
                    $data[$period_val] = 0;
                }
                $data[$period_val] += $value;
            }
        }
        return $data;
    }

    public function actionSmtMountingReport($value='')
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

        $tmp_report = SmtOutputMonthlyInsertPoint02::find()
        ->select([
            'period',
            'planed_loss_minute' => 'SUM(planed_loss_minute)',
            'out_section_minute' => 'SUM(out_section_minute)',
            'working_time' => 'SUM(working_time)',
            'TOTAL_POINT_ALL' => 'SUM(TOTAL_POINT_ALL)',
        ])
        ->groupBy('period')
        ->orderBy('period')
        ->all();
        
        $period_arr = $tmp_data = [];
        foreach ($tmp_fiscal_period as $value) {
            $period_arr[] = $value->PERIOD;
            $tmp_data[$value->PERIOD] = [
                'planed_loss_minute' => null,
                'out_section_minute' => null,
                'working_time' => null,
                'TOTAL_POINT_ALL' => null,
                'ratio' => null,
            ];
            foreach ($tmp_report as $report_val) {
                if ($report_val->period == $value->PERIOD) {
                    $tmp_data[$value->PERIOD]['planed_loss_minute'] = $report_val->planed_loss_minute;
                    $tmp_data[$value->PERIOD]['out_section_minute'] = $report_val->out_section_minute;
                    $tmp_data[$value->PERIOD]['working_time'] = $report_val->working_time;
                    $tmp_data[$value->PERIOD]['TOTAL_POINT_ALL'] = $report_val->TOTAL_POINT_ALL;
                    $pembagi = ($report_val->working_time - $report_val->planed_loss_minute - $report_val->out_section_minute);
                    if ($pembagi > 0) {
                        $tmp_data[$value->PERIOD]['ratio'] = round($report_val->TOTAL_POINT_ALL / $pembagi, 1);
                    }
                }
            }
        }

        return $this->render('smt-mounting-report', [
            'model' => $model,
            'period_arr' => $period_arr,
            'tmp_data' => $tmp_data,
        ]);
    }

    public function actionWipStandardTime($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $wip_location_arr = [
            'TEMP01' => 'FA',
            'TEMP02' => 'SA',
            'TEMP03' => 'WW',
            'TEMP04' => 'PT',
            'TEMP05' => 'PCB MI',
            'TEMP06' => 'SPU',
            'WI01' => 'Small Injection',
            'WI02' => '1600/850 Injection'
        ];

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

        $wip_standard_time = WipEffTbl::find()
        ->select([
            'period', 'child_analyst', 'child_analyst_desc',
            'lt_std' => 'SUM(lt_std)'
        ])
        ->where(['period' => $period_arr])
        ->groupBy('period, child_analyst, child_analyst_desc')
        ->orderBy('period')
        ->all();

        $tmp_data = [];
        foreach ($period_arr as $period_val) {
            foreach ($wip_location_arr as $loc_id => $loc_desc) {
                $tmp_data[$period_val][$loc_desc]['std_time'] = null;
                foreach ($wip_standard_time as $std_time_val) {
                    if ($std_time_val->period == $period_val && $std_time_val->child_analyst == $loc_id) {
                        $tmp_data[$period_val][$loc_desc]['std_time'] = $std_time_val->lt_std;
                    }
                }
            }
        }

        return $this->render('wip-standard-time', [
            'model' => $model,
            'period_arr' => $period_arr,
            'tmp_data' => $tmp_data,
            'wip_location_arr' => $wip_location_arr,
        ]);
    }

    public function actionSmtOutputMonthly($value='')
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $searchModel  = new SmtOutputMonthlySearch;

        $searchModel->period = date('Ym');
        if(\Yii::$app->request->get('period') !== null)
        {
            $searchModel->period = \Yii::$app->request->get('period');
        }

        $dataProvider = $searchModel->search($_GET);

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('smt-output-monthly', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionShipPrdReport($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        return $this->render('ship-prd-report', [
            'data' => $data,
        ]);
    }

    public function actionShipPrdMonthlyResult($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        if ($model->load($_GET)) {
            $data = ShipPrdMonthlyResult::find()->where(['PERIOD' => $model->period])->one();
        } else {
            $data = ShipPrdMonthlyResult::find()->orderBy('PERIOD DESC')->one();
            $model->period = $data->PERIOD;
        }

        return $this->render('ship-prd-monthly-result', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionInjMachineStatus($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data_machine = InjMachineTbl::find()->all();
        $data_molding = InjMoldingTbl::find()->all();

        return $this->render('inj-machine-status', [
            'data_machine' => $data_machine,
            'data_molding' => $data_molding,
        ]);
    }

    public function actionInjMoldingStatus($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'running' => [],
            'ready' => [],
            'maintenance' => [],
        ];

        $tmp_molding = InjMoldingTbl::find()->orderBy('SHOT_PCT DESC, MOLDING_NAME')->all();
        foreach ($tmp_molding as $key => $value) {
            if ($value->MOLDING_STATUS == 0) {
                $data['ready'][] = $value;
            } elseif ($value->MOLDING_STATUS == 1) {
                $data['running'][] = $value;
            } else {
                $data['maintenance'][] = $value;
            }
        }

        $loc_data_arr = ArrayHelper::map(InjMachineTbl::find()->all(), 'MACHINE_ID', 'MACHINE_ALIAS');

        return $this->render('inj-molding-status', [
            'data' => $data,
            'loc_data_arr' => $loc_data_arr,
        ]);
    }

    public function actionInjMouldingCountData($value='')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data_return = [];
        $tmp_machine = InjMachineTbl::find()->all();
        foreach ($tmp_machine as $key => $value) {
            $moulding_name = '<i class="text-red">(NO MOULDING SET)</i>';
            $last_update = '-';
            $item = '<i class="text-red">(NO ITEM SET)</i>';

            if ($value->MOLDING_ID != null) {
                $moulding_name = $value->MOLDING_NAME;
                $last_update = date('d M Y H:i', strtotime($value->LAST_UPDATE));
            }
            if ($value->ITEM != null) {
                $item = $value->ITEM_DESC;
            }

            $data_return[$value->MACHINE_ID] = [
                'MACHINE_DESC' => $value->MACHINE_DESC,
                'MOULDING_NAME' => $moulding_name,
                'LAST_UPDATE' => $last_update,
                'TOTAL_COUNT' => $value->TOTAL_COUNT,
                'ITEM' => $value->ITEM,
                'ITEM_DESC' => $item,
            ];
        }

        return $data_return;
    }

    public function actionInjMoldingCount($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];

        $tmp_machine = InjMachineTbl::find()->all();

        foreach ($tmp_machine as $key => $value) {
            $molding_name = '<i class="text-red">(NO MOLDING SET)</i>';
            $current_count = 0;
            $last_update = '-';
            $item = '<i class="text-red">(NO ITEM SET)</i>';
            if ($value->MOLDING_ID != null) {
                $tmp_molding = InjMoldingTbl::findOne($value->MOLDING_ID);
                $molding_name = $value->MOLDING_NAME;
                $current_count = $tmp_molding->TOTAL_COUNT;
                $last_update = $tmp_molding->LAST_UPDATE;
                
            }
            if ($value->ITEM != null) {
                $item = $value->ITEM_DESC;
            }
            $data[$value->MACHINE_ID] = [
                'machine' => $value->MACHINE_DESC,
                'molding_name' => $molding_name,
                'current_count' => $current_count,
                'last_update' => $last_update,
                'item' => $item,
            ];
        }

        return $this->render('inj-molding-count', [
            'data' => $data,
        ]);
    }

    public function actionInflamMap()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $category_arr = ['FLAMMABLE', 'HEALTH HAZARD'];

        $loc_data = TraceItemDtrLoc::find()->where(['FLAG' => 1])->all();

        $sensor_data_arr = ArrayHelper::map(SensorTbl::find()->all(), 'map_no', 'temparature');

        $tmp_data = TraceItemDtrView::find()
        ->select([
            'LOC_DESC', 'SAFETY_CATEGORY_1',
            'TOTAL_KG' => 'SUM(CASE WHEN UM = \'KG\' THEN NILAI_INVENTORY ELSE 0 END)',
            'TOTAL_L' => 'SUM(CASE WHEN UM = \'L\' THEN NILAI_INVENTORY ELSE 0 END)'
        ])
        ->where([
            'AVAILABLE' => 'Y',
        ])
        ->groupBy(['LOC_DESC', 'SAFETY_CATEGORY_1'])
        ->all();

        $tmp_data2 = [];
        foreach ($tmp_data as $key => $value) {
            $tmp_data2[$value->LOC_DESC][$value->SAFETY_CATEGORY_1] = [
                'kg' => $value->TOTAL_KG,
                'l' => $value->TOTAL_L
            ];
        }

        $data_arr = [];
        foreach ($loc_data as $loc_val) {
            $tmp_suhu = '-';
            if ($loc_val->MAP_NO != null && isset($sensor_data_arr[$loc_val->MAP_NO])) {
                $tmp_suhu = $sensor_data_arr[$loc_val->MAP_NO];
            }
            $data_arr[$loc_val->LOC_DESC]['temperature'] = $tmp_suhu;
            $data_arr[$loc_val->LOC_DESC]['location'] = [
                'top' => $loc_val->TOP_POS,
                'left' => $loc_val->LEFT_POS,
            ];
            foreach ($category_arr as $cat_val) {
                $total_kg = $total_l = 0;
                foreach ($tmp_data as $data_val) {
                    if ($data_val->LOC_DESC == $loc_val->LOC_DESC && $data_val->SAFETY_CATEGORY_1 == $cat_val) {
                        $total_kg = $data_val->TOTAL_KG;
                        $total_l = $data_val->TOTAL_L;
                    }
                }
                $data_arr[$loc_val->LOC_DESC]['qty'][] = [
                    'kg' => $total_kg,
                    'l' => $total_l
                ];
            }
        }

        return $this->render('inflam-map', [
            'loc_data' => $loc_data,
            'data_arr' => $data_arr,
            'tmp_data2' => $tmp_data2,
        ]);
    }

    public function actionScrapMonthly($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $model = new \yii\base\DynamicModel([
            'location', 'fiscal_year'
        ]);
        $model->addRule(['location', 'fiscal_year'], 'required');
        $model->location = 'ALL';

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        if ($model->load($_GET)) { }

        $tmp_location_for_dropdown = SapGrGiByLocLog::find()->select(['storage_loc', 'storage_loc_desc'])->groupBy(['storage_loc', 'storage_loc_desc'])->orderBy('storage_loc_desc')->all();
        $location_dropdown = [
            'ALL' => 'ALL LOCATIONS'
        ];
        foreach ($tmp_location_for_dropdown as $key => $value) {
            $location_dropdown[$value->storage_loc] = $value->storage_loc_desc;
        }

        return $this->render('scrap-monthly', [
            'model' => $model,
            'tmp_location_for_dropdown' => $tmp_location_for_dropdown,
        ]);
    }

    public function actionInflamStock($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $model = new \yii\base\DynamicModel([
            'location'
        ]);
        $model->addRule(['location'], 'required');

        $data = [];
        $detail_data = null;
        if ($model->load($_GET)) {
            $tmp_category_arr = TraceItemDtrView::find()->select('SAFETY_CATEGORY_1')->where('SAFETY_CATEGORY_1 IS NOT NULL')->groupBy('SAFETY_CATEGORY_1')->orderBy('SAFETY_CATEGORY_1')->all();

            $tmp_data = TraceItemDtrView::find()
            ->select([
                'LOC_DESC', 'SAFETY_CATEGORY_1',
                'TOTAL_KG' => 'SUM(CASE WHEN UM = \'KG\' THEN NILAI_INVENTORY ELSE 0 END)',
                'TOTAL_L' => 'SUM(CASE WHEN UM = \'L\' THEN NILAI_INVENTORY ELSE 0 END)'
            ])
            ->where([
                'AVAILABLE' => 'Y',
                'LOC_DESC' => $model->location
            ])
            ->groupBy(['LOC_DESC', 'SAFETY_CATEGORY_1'])
            ->all();

            
            foreach ($tmp_category_arr as $category_val) {
                $category = $category_val->SAFETY_CATEGORY_1;
                $total_kg = $total_l = 0;
                foreach ($tmp_data as $data_val) {
                    if ($data_val->SAFETY_CATEGORY_1 == $category) {
                        $total_kg = $data_val->TOTAL_KG;
                        $total_l = $data_val->TOTAL_L;
                    }
                }
                $data[$category]['kg'] = $total_kg;
                $data[$category]['l'] = $total_l;
            }

            $detail_data = TraceItemDtrView::find()
            ->select([
                'ITEM', 'ITEM_DESC', 'UM', 'SAFETY_CATEGORY_1',
                'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)'
            ])
            ->where([
                'AVAILABLE' => 'Y',
                'LOC_DESC' => $model->location
            ])
            ->andWhere('SAFETY_CATEGORY_1 IS NOT NULL')
            ->groupBy(['ITEM', 'ITEM_DESC', 'UM', 'SAFETY_CATEGORY_1'])
            ->orderBy('SAFETY_CATEGORY_1, NILAI_INVENTORY DESC')
            ->all();
        }

        $location_arr = ArrayHelper::map(TraceItemDtr::find()->select('LOC_DESC')->groupBy('LOC_DESC')->orderBy('LOC_DESC')->all(), 'LOC_DESC', 'LOC_DESC');

        return $this->render('inflam-stock', [
            'data' => $data,
            'detail_data' => $detail_data,
            'model' => $model,
            'location_arr' => $location_arr,
        ]);
    }

    public function actionStockMonitoringAvg()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'category'
        ]);
        $model->addRule(['from_date', 'to_date', 'category'], 'required');

        $model->from_date = date('Y-m-d', strtotime($today . ' -2 weeks'));
        $model->to_date = $today;
        $model->category = 'CRITICAL';

        if ($model->load($_GET)) {

        }

        if ($model->category == 'CRITICAL') {
            $tmp_item_filter = ArrayHelper::map(TraceItemHdr::find()->where(['CRITICAL_CATEGORY' => 'CRITICAL'])->all(), 'ITEM', 'ITEM_DESC');
        } else {
            $tmp_item_filter = ArrayHelper::map(TraceItemHdr::find()->all(), 'ITEM', 'ITEM_DESC');
        }

        $tmp_dtr = TraceItemDtr::find()
        ->select([
            'ITEM', 'ITEM_DESC', 'UM', 'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)', 'LAST_UPDATE' => 'MAX(LAST_UPDATE)'
        ])
        ->where([
            'AVAILABLE' => 'Y'
        ])
        ->groupBy('ITEM, ITEM_DESC, UM')
        ->orderBy('ITEM_DESC')
        ->all();

        $item_arr = $tmp_data_total = [];
        foreach ($tmp_dtr as $value) {
            if (isset($tmp_item_filter[$value->ITEM])) {
                $item_arr[] = $value->ITEM;
            //$item_description_arr[$value->ITEM] = $value->ITEM_DESC;
                $initial_stock = $value->NILAI_INVENTORY;
                $tmp_data_total[$value->ITEM]['actual']['current_stock'] = $initial_stock;
                $tmp_data_total[$value->ITEM]['actual']['last_update'] = $value->LAST_UPDATE;
                $tmp_data_total[$value->ITEM]['description'] = $value->ITEM_DESC;
                $tmp_data_total[$value->ITEM]['um'] = $value->UM;

                $tmp_sap_current_stock = SapGrGiByPlant::find()->where([
                    'plant' => '8250',
                    'material' => $value->ITEM
                ])->one();

                $sap_initial_stock = 0;
                $sap_stock_last_update = null;
                if ($tmp_sap_current_stock) {
                    $sap_initial_stock = $tmp_sap_current_stock->ending_balance;
                    $sap_stock_last_update = date('Y-m-d', $tmp_sap_current_stock->file_date);
                }

                $tmp_data_total[$value->ITEM]['sap']['current_stock'] = $sap_initial_stock;
                //$tmp_data_total[$value->ITEM]['sap']['last_update'] = $sap_stock_last_update;

                $tmp_log = TraceItemDtrLog::find()
                ->select([
                    'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'QTY_IN' => 'ISNULL(SUM(QTY_IN), 0)', 'QTY_OUT' => 'ISNULL(SUM(QTY_OUT), 0)'
                ])
                ->where([
                    'ITEM' => $value->ITEM,
                ])
                ->andWhere(['>=', 'POST_DATE', $model->from_date])
                ->andWhere('POST_DATE IS NOT NULL')
                ->groupBy(['POST_DATE'])
                ->all();

                $tmp_dtr_info = TraceItemDtr::find()
                ->select([
                    'POST_DATE' => 'CAST(POST_DATE AS DATE)'
                ])
                ->where([
                    'ITEM' => $value->ITEM,
                ])
                ->andWhere(['>=', 'POST_DATE', $model->from_date])
                ->andWhere('POST_DATE IS NOT NULL')
                ->orderBy('POST_DATE')
                ->one();

                $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
                $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

                for($i = $end; $i >= $begin; $i->modify('-1 day')){
                    $tgl = $i->format("Y-m-d");

                    $tmp_data_total[$value->ITEM]['actual']['stock_arr'][$tgl] += $initial_stock;

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
                        $tmp_log_last_update = TraceItemDtr::find()
                        ->select([
                            'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)'
                        ])
                        ->where([
                            'ITEM' => $value->ITEM
                        ])
                        ->andWhere(['>=', 'POST_DATE', $model->from_date])
                        ->andWhere('POST_DATE IS NOT NULL')
                        ->groupBy('POST_DATE')
                        ->all();

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
                if (count($tmp_data_total[$value->ITEM]['actual']['stock_arr']) > 0) {
                    ksort($tmp_data_total[$value->ITEM]['actual']['stock_arr']);
                    $tmp_data_total[$value->ITEM]['actual']['avg'] = array_sum($tmp_data_total[$value->ITEM]['actual']['stock_arr']) / count($tmp_data_total[$value->ITEM]['actual']['stock_arr']);
                }
            }
        }

        $tmp_sap_log_arr = SapMaterialDocumentBc::find()
        ->select([
            'posting_date' => 'CAST(posting_date AS date)', 'material', 'qty_in' => 'SUM(qty_in)', 'qty_out' => 'SUM(qty_out)', 'entered_datetime' => 'MAX(entered_datetime)'
        ])
        ->where([
            'plant' => '8250',
            'material' => $item_arr
        ])
        ->andWhere(['>=', 'posting_date', $model->from_date])
        //->andWhere(['<=', 'posting_date', $sap_stock_last_update])
        ->groupBy('posting_date, material')
        ->orderBy('posting_date DESC, material')
        ->all();

        foreach ($tmp_data_total as $item => $value) {
            $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
            $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

            $sap_initial_stock = $value['sap']['current_stock'];

            for($i = $end; $i >= $begin; $i->modify('-1 day')){
                $tgl = $i->format("Y-m-d");
                /*if ($tgl > $sap_stock_last_update) {
                    $tmp_data_sap_stock[$tgl] = null;
                } else {
                    $tmp_data_sap_stock[$tgl] = $sap_initial_stock;
                }*/
                $tmp_data_total[$item]['sap']['stock_arr'][$tgl] = round($sap_initial_stock);

                foreach ($tmp_sap_log_arr as $tmp_sap_log) {
                    if ($tgl == $tmp_sap_log->posting_date && $tmp_sap_log->material == $item) {
                        $sap_initial_stock += $tmp_sap_log->qty_out;
                        $sap_initial_stock -= $tmp_sap_log->qty_in;

                        if (!isset($tmp_data_total[$item]['sap']['last_update'])) {
                            $tmp_data_total[$item]['sap']['last_update'] = $tmp_sap_log->posting_date;
                        } else {
                            if (strtotime($value->posting_date) > strtotime($tmp_data_total[$item]['sap']['last_update'])) {
                                $tmp_data_total[$item]['sap']['last_update'] = $tmp_sap_log->posting_date;
                            }
                        }
                    }
                }
            }

            if (count($tmp_data_total[$item]['sap']['stock_arr']) > 0) {
                ksort($tmp_data_total[$item]['sap']['stock_arr']);
                $tmp_data_total[$item]['sap']['avg'] = array_sum($tmp_data_total[$item]['sap']['stock_arr']) / count($tmp_data_total[$item]['sap']['stock_arr']);
            }
        }

        $for_sorting = [];
        foreach ($tmp_data_total as $key => $value) {
            $pct = 0;
            if ($value['sap']['avg'] > 0) {
                $pct = round(($value['actual']['avg'] / $value['sap']['avg'] - 1) * 100, 1);
            } else {
                $pct = round((0 - 1) * 100, 1);
            }
            $tmp_data_total[$key]['pct'] = $pct;
            $for_sorting[$key] = $pct;
        }

        if (count($for_sorting) > 0) {
            asort($for_sorting);
        }

        $data = [];
        foreach ($for_sorting as $key => $value) {
            $data[$key] = $tmp_data_total[$key];
        }

        return $this->render('stock-monitoring-avg', [
            'model' => $model,
            'tmp_data_total' => $tmp_data_total,
            'data' => $data,
        ]);
    }

    public function getFloTotalAmount($period)
    {
        $output = SernoOutput::find()->select([
            'so', 'gmc',
            'output' => 'SUM(output)'
        ])
        ->where(['id' => $period])
        ->groupBy('so, gmc')
        ->all();

        $price_arr = SapSoPrice::find()->where(['period_plan' => $period])->all();

        $grandtotal = 0;
        $not_found_arr = [];
        foreach ($output as $output_val) {
            $tmp_id = $output_val->so . '-' . $output_val->gmc;
            $tmp_amt = 0;
            foreach ($price_arr as $price_val) {
                if ($price_val->so_no_material_number == $tmp_id) {
                    $tmp_amt = $output_val->output * $price_val->price_master_usd;
                }
            }
            $grandtotal += $tmp_amt;
            if ($tmp_amt == 0) {
                $not_found_arr[] = $tmp_id;
            }
            /*if (isset($price_arr[$tmp_id])) {
                $grandtotal += ($output_val->output * $price_arr[$tmp_id]);
            } else {
                $not_found_arr[] = $tmp_id;
            }*/
        }

        return [
            'total_amount' => $grandtotal,
            'not_found_arr' => $not_found_arr,
            'price_arr' => count($price_arr)
        ];
    }

    public function actionSapVsFlo()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $this_month_period = date('Ym');
        $last_month_period = date('Ym', strtotime(' -1 month'));

        $tmp_sap_so = SapSoPlanActual::find()
        ->select([
            'period_plan',
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN amount_usd ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN amount_usd ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN amount_usd ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN amount_usd ELSE 0 END)',
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
            $total_amount = $this->getFloTotalAmount($value->period_plan);
            if ($total_plan > 0) {
                $tmp_export_pct = round(($total_export / $total_plan) * 100);
                $tmp_output_pct = round(($total_amount['total_amount'] / $total_plan) * 100);
            }
            if ($value->period_plan == $last_month_period) {
                $last_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($last_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                    'total_amount' => $total_amount,
                ];
            } elseif ($value->period_plan == $this_month_period) {
                $this_month_data = [
                    'plan' => $total_plan,
                    'export' => $total_export,
                    'period' => date('M\' Y', strtotime($this_month_period . '01')),
                    'export_pct' => $tmp_export_pct,
                    'output' => $output_qty,
                    'output_pct' => $tmp_output_pct,
                    'total_amount' => $total_amount,
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
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN amount_usd ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN amount_usd ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN amount_usd ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN amount_usd ELSE 0 END)',
        ])
        ->where(['period_plan' => [$last_month_period, $this_month_period]])
        //->andWhere(['<>', 'BU', 'OTHER'])
        ->groupBy('period_plan')
        ->all();

        $tmp_last_update = SapSoPlanActual::find()->select(['last_updated' => 'MAX(last_updated)'])->one();

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
            'last_update' => $tmp_last_update->last_updated,
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
            'total_early' => 'SUM(CASE WHEN otd = \'EARLY\' THEN amount_usd ELSE 0 END)',
            'total_otd' => 'SUM(CASE WHEN otd = \'OTD\' THEN amount_usd ELSE 0 END)',
            'total_outstanding' => 'SUM(CASE WHEN otd = \'OUTSTANDING\' THEN amount_usd ELSE 0 END)',
            'total_late' => 'SUM(CASE WHEN otd = \'LATE\' THEN amount_usd ELSE 0 END)',
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
        $today = date('Y-m-d');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'item'
        ]);
        $model->addRule(['from_date', 'to_date', 'item'], 'required');

        $model->from_date = date('Y-m-d', strtotime($today . ' -1 month'));
        $model->to_date = $today;

        /*$item_arr = ArrayHelper::map(TraceItemHdr::find()->select(['ITEM', 'ITEM_DESC'])->where('ITEM IS NOT NULL')->groupBy('ITEM, ITEM_DESC')->orderBy('ITEM_DESC')->all(), 'ITEM', 'itemDescription');*/

        $tmp_item_dropdown1 = ArrayHelper::map(TraceItemHdr::find()->select(['ITEM', 'ITEM_DESC'])->where('ITEM IS NOT NULL')->andWhere(['CRITICAL_CATEGORY' => 'CRITICAL'])->orderBy('ITEM_DESC')->all(), 'ITEM', 'itemDescription');
        $tmp_item_dropdown2 = ArrayHelper::map(TraceItemHdr::find()->select(['ITEM', 'ITEM_DESC'])->where('ITEM IS NOT NULL')->andWhere(['CRITICAL_CATEGORY' => 'NORMAL'])->orderBy('ITEM_DESC')->all(), 'ITEM', 'itemDescription');

        $item_dropdown = [
            'CRITICAL' => $tmp_item_dropdown1,
            'NORMAL' => $tmp_item_dropdown2,
        ];

        $tmp_data = $tmp_data_total = $tmp_data_sap_stock = [];
        $item_info = null;
        $model_load = false;
        $actual_stock_by_loc = [];

        if ($model->load($_GET)) {
            $model_load = true;
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
            ->all();

            $tmp_sum_nilai_inventory = 0;
            foreach ($tmp_dtr as $key => $value) {
                $tmp_sum_nilai_inventory += $value->NILAI_INVENTORY;
                $actual_stock_by_loc[$value->LOC_DESC] = $value->NILAI_INVENTORY;
            }

            $item_info = TraceItemHdr::find()->where(['ITEM' => $model->item])->one();

            //foreach ($tmp_dtr as $dtr_val) {
            $initial_stock = $tmp_sum_nilai_inventory;

            $begin = new \DateTime(date('Y-m-d', strtotime($model->from_date)));
            $end = new \DateTime(date('Y-m-d', strtotime($model->to_date)));

            $tmp_log = TraceItemDtrLog::find()
            ->select([
                'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'QTY_IN' => 'ISNULL(SUM(QTY_IN), 0)', 'QTY_OUT' => 'ISNULL(SUM(QTY_OUT), 0)',
            ])
            ->where([
                'ITEM' => $model->item,
            ])
            ->andWhere(['>=', 'POST_DATE', $model->from_date])
            ->andWhere('POST_DATE IS NOT NULL')
            ->groupBy(['POST_DATE'])
            ->all();

            $tmp_dtr_info = TraceItemDtr::find()
            ->select([
                'POST_DATE' => 'CAST(POST_DATE AS DATE)'
            ])
            ->where([
                'ITEM' => $model->item,
            ])
            ->andWhere(['>=', 'POST_DATE', $model->from_date])
            ->andWhere('POST_DATE IS NOT NULL')
            ->orderBy('POST_DATE')
            ->one();

            for($i = $end; $i >= $begin; $i->modify('-1 day')){
                $tgl = $i->format("Y-m-d");

                //$tmp_data[$dtr_val->LOC_DESC][$tgl] = $initial_stock;
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
                    $tmp_log_last_update = TraceItemDtr::find()
                    ->select([
                        'POST_DATE' => 'CAST(POST_DATE AS DATE)', 'NILAI_INVENTORY' => 'SUM(NILAI_INVENTORY)'
                    ])
                    ->where([
                        'ITEM' => $model->item
                    ])
                    ->andWhere(['>=', 'POST_DATE', $model->from_date])
                    ->andWhere('POST_DATE IS NOT NULL')
                    ->groupBy('POST_DATE')
                    ->all();

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
            //} //end actual stock
            
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

        } //close $model->load

        ksort($tmp_data_total);
        ksort($tmp_data_sap_stock);

        $tmp_data_total2 = $tmp_data_sap_stock2 = $tmp_data_diff = [];
        $sap_val_arr = $actual_val_arr = [];
        foreach ($tmp_data_sap_stock as $key => $value) {
            $post_date = (strtotime($key . " +7 hours") * 1000);
            $tmp_data_total2[] = [
                'x' => $post_date,
                'y' => ($tmp_data_total[$key]),
            ];
            $tmp_data_sap_stock2[] = [
                'x' => $post_date,
                'y' => ($value),
            ];
            $tmp_diff = $tmp_data_total[$key] - $value;
            $tmp_data_diff[] = $tmp_diff;
            //if ($tmp_data_total[$key] != 0) {
                $actual_val_arr[] = $tmp_data_total[$key];
            //}
            //if ($value != 0) {
                $sap_val_arr[] = $value;
            //}
        }

        $tmp_avg_actual = 0;
        if (count($actual_val_arr) > 0) {
            $tmp_avg_actual = array_sum($actual_val_arr) / count($actual_val_arr);
        }
        $tmp_avg_sap = 0;
        if (count($sap_val_arr) > 0) {
            $tmp_avg_sap = array_sum($sap_val_arr) / count($sap_val_arr);
        }

        $pct = 0;
        if ($model_load) {
            if ($tmp_avg_sap > 0) {
                $pct = round(($tmp_avg_actual / $tmp_avg_sap - 1) * 100, 1);
            } else {
                $pct = round((0 - 1) * 100, 1);
            }
        }

        $diff_avg = 0;
        if (count($tmp_data_diff) > 0) {
            $diff_avg = array_sum($tmp_data_diff)/count($tmp_data_diff);
        }

        $data[] = [
            'name' => 'ACTUAL QTY',
            'data' => $tmp_data_total2
        ];
        $data[] = [
            'name' => 'SAP QTY',
            'data' => $tmp_data_sap_stock2
        ];

        return $this->render('stock-monitoring', [
            'model' => $model,
            'item_arr' => $item_dropdown,
            'tmp_data' => $tmp_data,
            'actual_stock_by_loc' => $actual_stock_by_loc,
            'data' => $data,
            'pct' => $pct,
            'diff_avg' => $diff_avg,
            'um' => $item_info->UM,
            'item_desc' => $item_info->itemDescription,
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
            'defect_smt' => 'SUM(CASE WHEN pcb_process = \'SMT\' AND pcb_ng_found IN (\'FCT\', \'ICT\') THEN ng_qty ELSE 0 END)',
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

    public function actionDataMonitoringData($value='')
    {
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this_time = date('Y-m-d H:i:s');

        $tmp_data_client = DataMonitoringFa::find()
        ->where(['visible' => 1])
        ->orderBy('delay_second DESC')
        ->all();

        $tmp_status_arr = [];
        $index = 0;
        foreach ($tmp_data_client as $key => $value) {
            $tmp_new_class = 'client-widget bg-green';
            if ($value->delay_second > 3600) {
                $tmp_new_class = 'client-widget bg-red';
            }

            $tmp_status_arr[$index]['new_class'] = $tmp_new_class;
            $tmp_status_arr[$index]['line'] = $value->line;
            $tmp_status_arr[$index]['last_update'] = date('d M\' Y H:i', strtotime($value->lastupdated));
            $tmp_status_arr[$index]['delay_second'] = $value->delay_second;

            $index++;
        }

        return $tmp_status_arr;
    }

    public function actionDataMonitoring($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = DataMonitoringFa::find()
        ->where(['visible' => 1])
        ->orderBy('delay_second DESC')
        ->all();

        return $this->render('data-monitoring', [
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