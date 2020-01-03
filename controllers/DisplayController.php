<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

//production-monthly-inspection
use app\models\InspectionReportView;
use app\models\SernoInput;
use app\models\PlanReceivingPeriod;

//parts-picking-status
use app\models\PickingLocation;
use app\models\VisualPickingView02;
use app\models\VisualPickingView;

//smt-dandori
use app\models\WipEff03Dandori05;

//ng-report
use app\models\MntCorrectiveView;

//monthly-overtime-by-section
use app\models\SplView;
use app\models\Karyawan;
use app\models\CostCenter;
use app\models\FiscalTbl;

//hrga-spl-report-daily
use app\models\SplOvertimeBudget;

//overtime-monthly-summary
use app\models\search\OvertimeMonthlySummarySearch;

//top-overtime-data
use app\models\search\TopOvertimeDataSearch;

//hr-complaint
use app\models\search\HrComplaintSearch;
use app\models\HrComplaint;

//plan receiving calendar
use app\models\PlanReceiving;

use app\models\MachineIotCurrentEffLog;
use app\models\MachineIotCurrentEffPershiftLog;

//go machine order
use app\models\GojekOrderView01;

use app\models\SernoOutput;

use app\models\MachineIot;
use app\models\MachineIotCurrent;
use app\models\GojekTbl;
use app\models\PcbNgDaily;
use app\models\MasalahPcb;
use app\models\GojekOrderTbl;
use app\models\MachineIotOutput;
use app\models\SernoCalendar;
use app\models\WipHdrDtr;
use app\models\MeetingEvent;
use app\models\MrbsRoom;
use app\models\GeneralFunction;
use app\models\SensorTbl;
use app\models\SensorLog;
use app\models\ProdAttendanceData;
use app\models\Toilet;
use app\models\StockWaitingNextProcess;
use app\models\KlinikInput;
use app\models\MachineIotOutputDtr;
use app\models\WwStockWaitingProcess02Open;
use app\models\WipLocation;
use app\models\FaMp02;
use app\models\FaMp01;
use app\models\BeaconTbl;
use app\models\WipEffTbl;
use app\models\BeaconTblTrack;
use app\models\BeaconWipView;
use app\models\Visitor;
use app\models\MasalahSmt;
use app\models\SprOut;
use app\models\OnhandNice;
use app\models\KanbanPchLog;
use app\models\GoSaTbl;
use app\models\DrossInput;
use app\models\DrossOutput;
use app\models\DrossStock;
use app\models\CrusherInput;
use app\models\CrusherTbl;
use app\models\SernoMaster;
use app\models\DataRepair;
use app\models\ClientLog;
use app\models\WipMpPlan;
use app\models\ProdAttendanceView01;
use app\models\SmtWorkingRatioByDayResult;
use app\models\SmtWorkingRatioByHourResult;
use app\models\SmtWorkingRatioByMonthResult;
use app\models\SmtPcbLog;

class DisplayController extends Controller
{
    public function actionSmtWorkingRatioByMonth()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'line'
        ]);
        $model->addRule(['from_date', 'to_date', 'line'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d', strtotime('-1 year'))));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        $model->line = 'LINE-02';

        $tmp_shift_date = SmtPcbLog::find()
        ->select(['shift_date' => 'MAX(shift_date)'])
        ->one();
        $max_shift_date = $tmp_shift_date->shift_date;

        if (strtotime($max_shift_date) < strtotime($model->to_date)) {
            $model->to_date = date('Y-m-t', strtotime($max_shift_date));
            $model->from_date = date('Y-m-01', strtotime($max_shift_date . ' -1 year'));
        }

        if ($model->load($_GET)) {

        }

        $tmp_working_ratio = SmtWorkingRatioByMonthResult::find()
        ->where([
            'AND',
            ['>=', 'start_period', date('Ym', strtotime($model->from_date))],
            ['<=', 'start_period', date('Ym', strtotime($model->to_date))]
        ])
        ->orderBy('start_period, mounter_stage')
        ->all();

        $tmp_data = [];
        foreach ($tmp_working_ratio as $key => $value) {
            $start_period = $value->start_period;
            if (!in_array($start_period, $categories)) {
                $categories[] = $start_period;
            }
            $tmp_data[$value->machine . '-' . $value->stage][] = [
                'y' => round($value->Working_Ratio_By_Month, 2)
            ];
        }

        $data = [];
        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $value
            ];
        }

        return $this->render('smt-working-ratio-by-month', [
            'model' => $model,
            'data' => $data,
            'categories' => $categories,
        ]);
    }

    public function actionSmtWorkingRatioByHour($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'line'
        ]);
        $model->addRule(['from_date', 'to_date', 'line'], 'required');

        $model->from_date = date('Y-m-d');
        $model->to_date = date('Y-m-d');
        $model->line = 'LINE-02';

        $tmp_shift_date = SmtPcbLog::find()
        ->select(['shift_date' => 'MAX(shift_date)'])
        ->one();
        $max_shift_date = $tmp_shift_date->shift_date;

        if (strtotime($max_shift_date) < strtotime($model->to_date)) {
            $model->from_date = $model->to_date = date('Y-m-d', strtotime($max_shift_date));
        }

        if ($model->load($_GET)) {

        }

        $tmp_working_ratio = SmtWorkingRatioByHourResult::find()
        ->where([
            'AND',
            ['>=', 'shift_date', date('Y-m-d', strtotime($model->from_date))],
            ['<=', 'shift_date', date('Y-m-d', strtotime($model->to_date))]
        ])
        ->orderBy('start_time_hour, mounter_stage')
        ->all();

        $tmp_data = [];
        foreach ($tmp_working_ratio as $key => $value) {
            $proddate = (strtotime($value->start_time_hour . " +7 hours") * 1000);
            $tmp_data[$value->machine . '-' . $value->stage][] = [
                'x' => $proddate,
                'y' => round($value->working_ratio_by_hour, 2)
            ];
        }

        $data = [];
        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $value
            ];
        }

        return $this->render('smt-working-ratio-by-hour', [
            'model' => $model,
            'data' => $data,
        ]);
    }

	public function actionSmtWorkingRatioByDay()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date', 'line'
        ]);
        $model->addRule(['from_date', 'to_date', 'line'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        $model->line = 'LINE-02';

        $tmp_shift_date = SmtPcbLog::find()
        ->select(['shift_date' => 'MAX(shift_date)'])
        ->one();
        $max_shift_date = $tmp_shift_date->shift_date;

        if (strtotime($max_shift_date) < strtotime($model->to_date)) {
            $model->to_date = date('Y-m-t', strtotime($max_shift_date));
            $model->from_date = date('Y-m-01', strtotime($max_shift_date));
        }

        if ($model->load($_GET)) {

        }

        $tmp_working_ratio = SmtWorkingRatioByDayResult::find()
        ->where([
        	'AND',
            ['>=', 'shift_date', date('Y-m-d', strtotime($model->from_date))],
            ['<=', 'shift_date', date('Y-m-d', strtotime($model->to_date))]
        ])
        ->orderBy('shift_date, mounter_stage')
        ->all();

        $tmp_data = [];
        foreach ($tmp_working_ratio as $key => $value) {
        	$proddate = (strtotime($value->shift_date . " +7 hours") * 1000);
        	$tmp_data[$value->machine . '-' . $value->stage][] = [
        		'x' => $proddate,
                'y' => round($value->working_ratio_by_day, 2)
        	];
        }

        $data = [];
        foreach ($tmp_data as $key => $value) {
        	$data[] = [
        		'name' => $key,
        		'data' => $value
        	];
        }

		return $this->render('smt-working-ratio-by-day', [
			'model' => $model,
			'data' => $data,
		]);
	}

    public function actionDailyClientNetwork($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = $tmp_data = [];

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {

        }

        $tmp_networking = ClientLog::find()
        ->select([
            'mac_address', 'tanggal',
            'count_merah' => 'SUM(count_merah)',
            'count_all' => 'SUM(count_all)',
        ])
        ->where([
            'AND',
            ['>=', 'tanggal', date('Y-m-d', strtotime($model->from_date))],
            ['<=', 'tanggal', date('Y-m-d', strtotime($model->to_date))]
        ])
        ->groupBy('mac_address, tanggal')
        ->orderBy('mac_address, tanggal')
        ->all();

        foreach ($tmp_networking as $key => $value) {
            $proddate = (strtotime($value->tanggal . " +7 hours") * 1000);
            $pct = 0;
            if ($value->count_all > 0) {
                $pct = round((($value->count_all - $value->count_merah) / $value->count_all) * 100, 1);
            }
            $tmp_data[$value->mac_address][] = [
                'x' => $proddate,
                'y' => $pct
            ];
        }

        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $value,
            ];
        }

        

        return $this->render('daily-client-network', [
            'data' => $data,
            'model' => $model,
        ]);
    }

    public function getWipShiftAttendance($loc_selection, $date)
    {
        $tmp_attendance = ProdAttendanceView01::find()
        ->select([
            'child_analyst', 'child_analyst_desc', 'posting_shift', 'shift',
            'total' => 'COUNT(nik)'
        ])
        ->where([
            'posting_shift' => $date
        ])
        ->groupBy('child_analyst, child_analyst_desc, posting_shift, shift')
        ->orderBy('child_analyst_desc')
        ->all();

        $mp_actual_arr = [];
        foreach ($loc_selection as $key => $value) {
            for ($i=1; $i <= 3; $i++) { 
                $total_mp = 0;
                foreach ($tmp_attendance as $key2 => $value2) {
                    if ($value2->child_analyst == $key && $value2->shift == $i) {
                        $total_mp = $value2->total;
                    }
                }
                $mp_actual_arr[$key][$i . ''] = $total_mp;
            }
        }

        return $mp_actual_arr;
    }

    public function actionTodayAttendance($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        $period = date('Ym');
        $data = [];

        $model = new \yii\base\DynamicModel([
            'post_date'
        ]);
        $model->addRule(['post_date'], 'required');
        $model->post_date = $today;

        if ($model->load($_GET)) {

        }

        $tmp_data1 = $tmp_data2 = [];
        $tmp_attendance1 = ProdAttendanceView01::find()
        ->select([
            'child_analyst', 'child_analyst_desc', 'posting_shift',
            'total' => 'COUNT(nik)'
        ])
        ->where([
            'posting_shift' => $model->post_date
        ])
        ->groupBy('child_analyst, child_analyst_desc, posting_shift')
        ->orderBy('child_analyst_desc')
        ->all();

        $loc_selection = \Yii::$app->params['attendance_wip_arr'];
        asort($loc_selection);
        //$tmp_location = WipLocation::find()->where(['child_analyst' => $loc_selection])->orderBy('child_analyst_desc')->all();
        $wip_mp_plan = ArrayHelper::map(WipMpPlan::find()->where(['period' => $period])->all(), 'child_analyst', 'mp_plan');
        $mp_arr = [];
        foreach ($loc_selection as $key1 => $location) {
            $mp_plan = isset($wip_mp_plan[$key1]) ? $wip_mp_plan[$key1] : 0;
            $mp_arr[$key1] = $mp_plan;
        }
        if (count($mp_arr) > 0) {
            arsort($mp_arr);
        }

        foreach ($mp_arr as $key => $value) {
            $location_str = $loc_selection[$key];
            $actual_mp = 0;
            foreach ($tmp_attendance1 as $key2 => $attendance1) {
                if ($key == $attendance1->child_analyst) {
                    $actual_mp = $attendance1->total;
                }
            }

            $data[$location_str] = [
                'plan' => $value,
                'actual' => $actual_mp,
                'key' => $key
            ];
        }

        $fa_mp_arr = FaMp02::find()
        ->where(['tgl' => $model->post_date])
        ->one();

        $data['FINAL ASSY']['actual'] = (int)$fa_mp_arr->total_mp;
        $data_by_shift = $this->getWipShiftAttendance($loc_selection, $model->post_date);
        $data_by_shift['WF01'] = [
            '1' => (int)$fa_mp_arr->total_mp,
            '2' => 0,
            '3' => 0,
        ];

        return $this->render('today-attendance', [
            'data' => $data,
            'model' => $model,
            'data_by_shift' => $data_by_shift,
        ]);
    }

    public function actionRepairKpi()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        //$today = '2019-12-11';

        $total_open = DataRepair::find()->where([
            'status' => 'OPEN',
            'flag' => 1
        ])->count();

        $tmp_total = DataRepair::find()->select([
            'out_date',
            'total_return' => 'SUM(CASE WHEN status = \'Return\' THEN 1 ELSE 0 END)',
            'total_scrap' => 'SUM(CASE WHEN status = \'Scrap\' OR status = \'EX-PE\' THEN 1 ELSE 0 END)',
            'total_ok' => 'SUM(CASE WHEN status = \'OK\' THEN 1 ELSE 0 END)',
        ])
        ->where([
            'out_date' => $today,
            'flag' => 1
        ])
        ->groupBy('out_date')
        ->one();

        $data_open = DataRepair::find()
        ->where([
            'status' => 'OPEN',
            'flag' => 1
        ])
        ->orderBy('in_date')
        ->all();

        return $this->render('repair-kpi', [
            'total_open' => $total_open,
            'total_return' => (int)$tmp_total->total_return,
            'total_scrap' => (int)$tmp_total->total_scrap,
            'total_ok' => (int)$tmp_total->total_ok,
            'data_open' => $data_open
        ]);
    }

    public function actionSensorLog()
    {
        $this->layout = 'clean';
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d', strtotime(' -1 month'))));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {
            # code...
        }

        $data_dummy = SensorLog::find()
        ->where([
            'AND',
            ['>=', 'system_date_time', date('Y-m-d H:i:s', strtotime($model->from_date . ' 00:00:01'))],
            ['<=', 'system_date_time', date('Y-m-d H:i:s', strtotime($model->to_date . ' 24:00:00'))]
        ])
        ->orderBy('map_no, system_date_time')
        ->asArray()
        ->all();

        foreach ($data_dummy as $value) {
            $proddate = (strtotime($value['system_date_time'] . " +7 hours") * 1000);
            $tmp_data_temperature[$value['area']][] = [
                'x' => $proddate,
                'y' => (int)$value['temparature']
            ];
            $tmp_data_humidity[$value['area']][] = [
                'x' => $proddate,
                'y' => (int)$value['humidity']
            ];
        }
        foreach ($tmp_data_temperature as $key => $value) {
            $data['temperature'][] = [
                'name' => $key,
                'data' => $value,
                'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
                'showInLegend' => false,
            ];
        }
        foreach ($tmp_data_humidity as $key => $value) {
            $data['humidity'][] = [
                'name' => $key,
                'data' => $value,
                'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
                'showInLegend' => false,
            ];
        }

        return $this->render('sensor-log', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionCrusherInputDaily($value='')
    {
        $this->layout = 'clean';
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $tgl_arr = [];
        $dross_date = $tmp_output = DrossOutput::find()->select('tgl')->groupBy('tgl')->orderBy('tgl DESC')->limit(2)->all();
        foreach ($dross_date as $key => $value) {
            $tgl_arr[] = $value->tgl;
        }

        $model->from_date = '2019-04-01';
        $model->to_date = date('Y-m-d');

        if ($model->load($_GET)) {
            # code...
        }

        $tmp_input = CrusherInput::find()
        ->select([
            'tgl',
            'fresh_inj' => 'SUM(fresh_inj)',
            'cr_inj' => 'SUM(cr_inj)',
        ])
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date],
            ['<=', 'tgl', $model->to_date]
        ])
        ->groupBy('tgl')
        ->orderBy('tgl')
        ->all();

        $tmp_data_new = $tmp_data_recycle = [];
        $total_in = $total_in_new = $total_in_recycle = 0;
        foreach ($tmp_input as $key => $value) {
            $proddate = (strtotime($value->tgl . " +7 hours") * 1000);
            $total_in_new += $value->fresh_inj;
            $total_in_recycle += $value->cr_inj;
            $tmp_data_new[] = [
                'x' => $proddate,
                'y' => (float)$value->fresh_inj
            ];
            $tmp_data_recycle[] = [
                'x' => $proddate,
                'y' => (float)$value->cr_inj
            ];
        }
        $total_in = (float)$total_in_new + (float)$total_in_recycle;

        $tmp_output = CrusherTbl::find()
        ->select([
            'date',
            'consume' => 'SUM(consume)',
        ])
        ->where([
            'AND',
            ['>=', 'date', $model->from_date],
            ['<=', 'date', $model->to_date]
        ])
        ->groupBy('date')
        ->all();

        $total_dross = $total_dross_recylce = $total_dross_scrap = 0;
        foreach ($tmp_output as $key => $value) {
            $total_dross += $value->consume;
            $total_dross_recylce += $value->consume;
        }
        $total_dross_scrap = $total_dross - $total_dross_recylce;
        $total_dross_scrap = 3194;

        $scrap_ratio = 0;
        $recycle_ratio = 0;
        if ($total_in_new > 0) {
            $scrap_ratio = round(($total_dross_scrap / $total_in_new) * 100, 1);
            $recycle_ratio = round(($total_in_recycle / $total_in_new) * 100, 1);
        }
        $in_recycle_ratio = 0;
        
        if ($total_in > 0) {
            
            $in_recycle_ratio = round(($total_in_recycle / $total_in) * 100, 1);
            
        }

        $data = [
            [
                'name' => 'RECYCLE',
                'data' => $tmp_data_recycle
            ],
            [
                'name' => 'NEW',
                'data' => $tmp_data_new
            ],
        ];

        $dross_stock = DrossStock::find()->orderBy('tgl DESC')->one();
        $dross_stock = [
            'st_dross' => 205.926,
            'st_recycle' => $total_dross_recylce - $total_in_recycle
        ];

        return $this->render('crusher-input-daily', [
            'data' => $data,
            'model' => $model,
            'total_in' => $total_in,
            'total_in_new' => $total_in_new,
            'total_in_recycle' => $total_in_recycle,
            'total_dross_scrap' => $total_dross_scrap,
            'total_dross' => $total_dross,
            'total_dross_recylce' => $total_dross_recylce,
            'scrap_ratio' => $scrap_ratio,
            'recycle_ratio' => $recycle_ratio,
            'in_recycle_ratio' => $in_recycle_ratio,
            'dross_stock' => $dross_stock
        ]);
    }

    public function actionDrossInputDaily($value='')
    {
        $this->layout = 'clean';
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $tgl_arr = [];
        $dross_date = $tmp_output = DrossOutput::find()->select('tgl')->groupBy('tgl')->orderBy('tgl DESC')->limit(2)->all();
        foreach ($dross_date as $key => $value) {
            $tgl_arr[] = $value->tgl;
        }
        $model->from_date = '2019-04-01';
        $model->to_date = $tgl_arr[0];
        //$model->from_date = date('Y-m-01', strtotime(date('Y-m-d', strtotime(' -2 months'))));
        //$model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {
            # code...
        }

        $tmp_input = DrossInput::find()
        ->select([
            'tgl_in',
            'new' => 'SUM(new)',
            'recycle' => 'SUM(recycle)',
        ])
        ->where([
            'AND',
            ['>=', 'tgl_in', $model->from_date],
            ['<=', 'tgl_in', $model->to_date]
        ])
        ->groupBy('tgl_in')
        ->orderBy('tgl_in')
        ->all();

        $tmp_data_new = $tmp_data_recycle = [];
        $total_in = $total_in_new = $total_in_recycle = 0;
        foreach ($tmp_input as $key => $value) {
            $proddate = (strtotime($value->tgl_in . " +7 hours") * 1000);
            $total_in_new += $value->new;
            $total_in_recycle += $value->recycle;
            $tmp_data_new[] = [
                'x' => $proddate,
                'y' => (float)$value->new
            ];
            $tmp_data_recycle[] = [
                'x' => $proddate,
                'y' => (float)$value->recycle
            ];
        }
        $total_in = (float)$total_in_new + (float)$total_in_recycle;

        $tmp_output = DrossOutput::find()
        ->select([
            'tgl',
            'dross' => 'SUM(dross)',
            'dross_recycle' => 'SUM(dross_recycle)'
        ])
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date],
            ['<=', 'tgl', $model->to_date]
        ])
        ->groupBy('tgl')
        ->all();

        $total_dross = $total_dross_recylce = $total_dross_scrap = 0;
        foreach ($tmp_output as $key => $value) {
            $total_dross += $value->dross;
            $total_dross_recylce += $value->dross_recycle;
        }
        $total_dross_scrap = $total_dross - $total_dross_recylce;

        $scrap_ratio = 0;
        $recycle_ratio = 0;
        if ($total_in_new > 0) {
            $scrap_ratio = round(($total_dross_scrap / $total_in_new) * 100, 1);
            $recycle_ratio = round(($total_in_recycle / $total_in_new) * 100, 1);
        }
        $in_recycle_ratio = 0;
        
        if ($total_in > 0) {
            
            $in_recycle_ratio = round(($total_in_recycle / $total_in) * 100, 1);
            
        }

        $data = [
            [
                'name' => 'RECYCLE',
                'data' => $tmp_data_recycle
            ],
            [
                'name' => 'NEW',
                'data' => $tmp_data_new
            ],
        ];

        $dross_stock = DrossStock::find()->orderBy('tgl DESC')->one();

        return $this->render('dross-input-daily', [
            'data' => $data,
            'model' => $model,
            'total_in' => $total_in,
            'total_in_new' => $total_in_new,
            'total_in_recycle' => $total_in_recycle,
            'total_dross_scrap' => $total_dross_scrap,
            'total_dross' => $total_dross,
            'total_dross_recylce' => $total_dross_recylce,
            'scrap_ratio' => $scrap_ratio,
            'recycle_ratio' => $recycle_ratio,
            'in_recycle_ratio' => $in_recycle_ratio,
            'dross_stock' => $dross_stock
        ]);
    }

    public function actionCriticalTempUpdate($value='')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $sensor_data = SensorTbl::find()
        ->where([
            'map_no' => [12, 13, 7, 8, 17, 18]
        ])
        ->orderBy('area')
        ->all();

        $title_arr = [
            '7' => '1. Line-X Booth (Black)<br/><span class="japanesse light-green">(黒ラインエックスのブース)</span>',
            '8' => '2. Line-X Booth (White)<br/><span class="japanesse light-green">(白ラインエックスのブース)</span>',
            '18' => '3. Oven Room 1<br/><span class="japanesse light-green">(強制乾燥室 1)</span>',
            '17' => '4. Oven Room 2<br/><span class="japanesse light-green">(強制乾燥室 2)</span>',
            '13' => '5. Inwax Piano 1<br/><span class="japanesse light-green">(インワックスのピアノ塗装 1)</span>',
            '12' => '6. Inwax Piano 13&14<br/><span class="japanesse light-green">(インワックスのピアノ塗装 13&14)</span>',
        ];

        $tbody = '';
        $temp_data_arr = $humi_data_arr = $standard_temp_arr = $standard_humi_arr = [];
        foreach ($sensor_data as $key => $value) {
            $temperature_value = $value->temparature;
            //$temperature_value = 50;
            if ($value->map_no == 17 || $value->map_no == 18) {
                if ($temperature_value >= $value->temp_min) {
                    $temp_data_arr[$value->map_no] = '<span class="text-green">' . $temperature_value . '</span>';
                } else {
                    $temp_data_arr[$value->map_no] = '<span class="blinked">' . $temperature_value . '</span>';
                }
            } else {
                if ($temperature_value <= $value->temp_max) {
                    $temp_data_arr[$value->map_no] = '<span class="text-green">' . $temperature_value . '</span>';
                } else {
                    $temp_data_arr[$value->map_no] = '<span class="blinked">' . $temperature_value . '</span>';
                }
            }
            
            $standard_temp_arr[$value->map_no] = $value->temp_min . ' - ' . $value->temp_max;

            $humidity_value = $value->humidity;
            if ($humidity_value >= $value->humi_min && $humidity_value <= $value->humi_max) {
                $humi_data_arr[$value->map_no] = '<span class="text-green">' . $humidity_value . '</span>';
            } else {
                $humi_data_arr[$value->map_no] = '<span class="blinked">' . $humidity_value . '</span>';
            }
            $standard_humi_arr[$value->map_no] = $value->humi_min . ' - ' . $value->humi_max;
        }

        $data = [
            'temp_data_arr' => $temp_data_arr,
            'humi_data_arr' => $humi_data_arr,
            'standard_humi_arr' => $standard_humi_arr,
            'standard_temp_arr' => $standard_temp_arr,
        ];

        return $data;
    }

    public function actionCriticalTempMonitoring($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = SensorTbl::find()
        ->where([
            'map_no' => [12, 13, 7, 8, 17, 18]
        ])
        ->orderBy('area')
        ->all();

        $title_arr = [
            '7' => '1. Line-X Booth (Black)<br/><span class="japanesse light-green">(黒ラインエックスのブース)</span>',
            '8' => '2. Line-X Booth (White)<br/><span class="japanesse light-green">(白ラインエックスのブース)</span>',
            '18' => '3. Oven Room 1<br/><span class="japanesse light-green">(強制乾燥室 1)</span>',
            '17' => '4. Oven Room 2<br/><span class="japanesse light-green">(強制乾燥室 2)</span>',
            '13' => '5. Inwax Piano 1<br/><span class="japanesse light-green">(インワックスのピアノ塗装 1)</span>',
            '12' => '6. Inwax Piano 13&14<br/><span class="japanesse light-green">(インワックスのピアノ塗装 13&14)</span>',
        ];

        return $this->render('critical-temp-monitoring', [
            'data' => $data,
            'title_arr' => $title_arr,
        ]);
    }
    public function actionPchKanbanDetail($period, $direct_indirect, $balance_no)
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];
        if ($balance_no == 1) {
            $where_arr = [
                'doc_minus' => 1
            ];
        } elseif ($balance_no == 2) {
            $where_arr = [
                'verikasi_minus' => 1
            ];
        } elseif ($balance_no == 3) {
            $where_arr = [
                'finance_rcv_minus' => 1
            ];
        } elseif ($balance_no == 4) {
            $where_arr = [
                'finance_transfer_minus' => 1
            ];
        }

        $params = [
            ':period' => $period,
        ];
        $sql = "{CALL INVOICE_KANBAN_NEW(:period)}";
        try {
            $result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryAll();
            foreach ($result as $key => $value) {
                $is_find = false;
                if ($value['source_data'] == $direct_indirect) {
                    if ($balance_no == 1) {
                        if ($value['doc_minus'] == 1) {
                            $is_find = true;
                        }
                    } elseif ($balance_no == 2) {
                        if ($value['verikasi_minus'] == 1) {
                            $is_find = true;
                        }
                    } elseif ($balance_no == 3) {
                        if ($value['finance_rcv_minus'] == 1) {
                            $is_find = true;
                        }
                    } elseif ($balance_no == 4) {
                        if ($value['finance_transfer_minus'] == 1) {
                            $is_find = true;
                        }
                    }
                    if ($is_find == true) {
                        $data[] = [
                            'period' => $value['period'],
                            'vendor_code' => $value['vendor_code'],
                            'vendor_name' => $value['vendor_name'],
                            'voucher_no' => $value['voucher_no'],
                            'invoice_act' => $value['invoice_act'],
                            'do' => $value['do'],
                            'currency' => $value['currency'],
                            'amount' => $value['amount'],
                            'pic' => $value['pic'],
                            'division' => $value['division'],
                            'term' => $value['term'],
                        ];
                    }
                }
            }
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }

        return $this->render('pch-kanban-detail', [
            'data' => $data
        ]);
    }
    public function actionPchKanbanData()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [
            'direct' => [
                'kanban_doc' => 0,
                'pch' => [
                    'received' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                    'verification' => [
                        'target' => 0,
                        'balance' => 0
                    ]
                ],
                'acc' => [
                    'verification' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                    'paid' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                ],
            ],
            'indirect' => [
                'kanban_doc' => 0,
                'pch' => [
                    'received' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                    'verification' => [
                        'target' => 0,
                        'balance' => 0
                    ]
                ],
                'acc' => [
                    'verification' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                    'paid' => [
                        'target' => 0,
                        'balance' => 0
                    ],
                ],
            ],
        ];

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        $result = null;
        if ($model->load($_GET)) {

        }

        $params = [
            ':period' => $model->period,
        ];
        $sql = "{CALL INVOICE_KANBAN_NEW(:period)}";
        $modal_data = [];
        try {
            $result = \Yii::$app->db_wsus->createCommand($sql, $params)->queryAll();
            foreach ($result as $key => $value) {
                if ($value['source_data'] == '01-SAP') {
                    $data['direct']['kanban_doc']++;
                    $data['direct']['pch']['received']['target'] += $value['doc_received'];
                    $data['direct']['pch']['received']['balance'] -= $value['doc_minus'];
                    $data['direct']['pch']['verification']['target'] += $value['verikasi_done'];
                    $data['direct']['pch']['verification']['balance'] -= $value['verikasi_minus'];
                    $data['direct']['acc']['verification']['target'] += $value['finance_rcv_done'];
                    $data['direct']['acc']['verification']['balance'] -= $value['finance_rcv_minus'];
                    $data['direct']['acc']['paid']['target'] += $value['finance_transfer_done'];
                    $data['direct']['acc']['paid']['balance'] -= $value['finance_transfer_minus'];
                    if ($value['doc_minus'] == 1) {
                        $modal_data['direct']['balance-1'][] = $value;
                    }
                    if ($value['verikasi_minus'] == 1) {
                        $modal_data['direct']['balance-2'][] = $value;
                    }
                    if ($value['finance_rcv_minus'] == 1) {
                        $modal_data['direct']['balance-3'][] = $value;
                    }
                    if ($value['finance_transfer_minus'] == 1) {
                        $modal_data['direct']['balance-4'][] = $value;
                    }
                    if ($value['finance_rcv_done'] == 1) {
                        $modal_data['direct']['acc-target'][] = $value;
                    }
                    
                } else {
                    $data['indirect']['kanban_doc']++;
                    $data['indirect']['pch']['received']['target'] += $value['doc_received'];
                    $data['indirect']['pch']['received']['balance'] -= $value['doc_minus'];
                    $data['indirect']['pch']['verification']['target'] += $value['verikasi_done'];
                    $data['indirect']['pch']['verification']['balance'] -= $value['verikasi_minus'];
                    $data['indirect']['acc']['verification']['target'] += $value['finance_rcv_done'];
                    $data['indirect']['acc']['verification']['balance'] -= $value['finance_rcv_minus'];
                    $data['indirect']['acc']['paid']['target'] += $value['finance_transfer_done'];
                    $data['indirect']['acc']['paid']['balance'] -= $value['finance_transfer_minus'];
                    if ($value['doc_minus'] == 1) {
                        $modal_data['indirect']['balance-1'][] = $value;
                    }
                    if ($value['verikasi_minus'] == 1) {
                        $modal_data['indirect']['balance-2'][] = $value;
                    }
                    if ($value['finance_rcv_minus'] == 1) {
                        $modal_data['indirect']['balance-3'][] = $value;
                    }
                    if ($value['finance_transfer_minus'] == 1) {
                        $modal_data['indirect']['balance-4'][] = $value;
                    }
                    if ($value['finance_rcv_done'] == 1) {
                        $modal_data['indirect']['acc-target'][] = $value;
                    }
                }
            }
        } catch (Exception $ex) {
            return json_encode($ex->getMessage());
        }

        $completion = 0;
        if ($data['direct']['kanban_doc'] + $data['indirect']['kanban_doc'] > 0) {
            $completion = round(($data['direct']['pch']['verification']['target'] + $data['indirect']['pch']['verification']['target']) / ($data['direct']['kanban_doc'] + $data['indirect']['kanban_doc']) * 100, 1);
        }

        return $this->render('pch-kanban-data', [
            'data' => $data,
            'modal_data' => $modal_data,
            'model' => $model,
            'result' => $result,
            'completion' => $completion,
        ]);
    }

    public function actionTemperatureOverDetail($map_no, $period, $shift, $area, $absolute, $category)
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        if ($absolute == 'ABSOLUTE') {
            if ($category == 'PRODUCTION') {
                $data_table = SensorLog::find()
                ->where([
                    'map_no' => $map_no,
                    'ref_abs' => 'ABSOLUTE',
                    'range_24_jam' => 'N',
                    'temp_over' => 1,
                    'period' => $period,
                    'shift' => $shift
                ])
                ->andWhere('day_name NOT IN (\'Saturday\', \'Sunday\')')
                ->orderBy('system_date_time')
                ->all();
            } else {
                $data_table = SensorLog::find()
                ->where([
                    'map_no' => $map_no,
                    'ref_abs' => 'ABSOLUTE',
                    'range_24_jam' => 'Y',
                    'temp_over' => 1,
                    'period' => $period,
                    'shift' => $shift
                ])
                ->orderBy('system_date_time')
                ->all();
            }
        } else {
            $data_table = SensorLog::find()
            ->where([
                'map_no' => $map_no,
                'ref_abs' => 'REFERENCE',
                'range_24_jam' => 'N',
                'temp_over' => 1,
                'period' => $period,
                'shift' => $shift
            ])
            ->andWhere('day_name NOT IN (\'Saturday\', \'Sunday\')')
            ->orderBy('system_date_time')
            ->all();
        }

        return $this->render('temperature-over-detail', [
            'data_table' => $data_table,
            'area' => $area,
        ]);
    }
    public function actionTemperatureOver($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $period = date('Ym');

        $model = new \yii\base\DynamicModel([
            'period', 'absolute_or_reference', 'production_or_warehouse'
        ]);
        $model->addRule(['period', 'absolute_or_reference', 'production_or_warehouse'], 'required');
        $model->period = $period;
        $model->absolute_or_reference = 'ABSOLUTE';
        $model->production_or_warehouse = 'PRODUCTION';

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        if ($model->load($_GET)) {

        }

        if ($model->absolute_or_reference == 'ABSOLUTE') {
            if ($model->production_or_warehouse == 'PRODUCTION') {
                $tmp_tbl = SensorLog::find()
                ->select([
                    'map_no', 'loc_no', 'factory', 'location', 'area', 'wh_prod',
                    'total_freq' => 'SUM(temp_over)',
                    'freq_shift1' => 'sum(CASE WHEN shift = 1 THEN temp_over ELSE 0 END)',
                    'freq_shift2' => 'sum(CASE WHEN shift = 2 THEN temp_over ELSE 0 END)',
                    'freq_shift3' => 'sum(CASE WHEN shift = 3 THEN temp_over ELSE 0 END)',
                ])
                ->where([
                    'ref_abs' => 'ABSOLUTE',
                    'range_24_jam' => 'N',
                    'temp_over' => 1,
                    'period' => $model->period
                ])
                ->andWhere('day_name NOT IN (\'Saturday\', \'Sunday\')')
                ->groupBy('map_no, loc_no , factory , location, area, wh_prod')
                ->orderBy('area')
                ->all();
            } else {
                $tmp_tbl = SensorLog::find()
                ->select([
                    'map_no', 'loc_no', 'factory', 'location', 'area', 'wh_prod',
                    'total_freq' => 'SUM(temp_over)',
                    'freq_shift1' => 'sum(CASE WHEN shift = 1 THEN temp_over ELSE 0 END)',
                    'freq_shift2' => 'sum(CASE WHEN shift = 2 THEN temp_over ELSE 0 END)',
                    'freq_shift3' => 'sum(CASE WHEN shift = 3 THEN temp_over ELSE 0 END)',
                ])
                ->where([
                    'ref_abs' => 'ABSOLUTE',
                    'range_24_jam' => 'Y',
                    'temp_over' => 1,
                    'period' => $model->period
                ])
                ->groupBy('map_no, loc_no , factory , location, area, wh_prod')
                ->orderBy('area')
                ->all();
            }
        } else {
            $tmp_tbl = SensorLog::find()
            ->select([
                'map_no', 'loc_no', 'factory', 'location', 'area', 'wh_prod',
                'total_freq' => 'SUM(temp_over)',
                'freq_shift1' => 'sum(CASE WHEN shift = 1 THEN temp_over ELSE 0 END)',
                'freq_shift2' => 'sum(CASE WHEN shift = 2 THEN temp_over ELSE 0 END)',
                'freq_shift3' => 'sum(CASE WHEN shift = 3 THEN temp_over ELSE 0 END)',
            ])
            ->where([
                'ref_abs' => 'REFERENCE',
                'range_24_jam' => 'N',
                'temp_over' => 1,
                'period' => $model->period
            ])
            ->andWhere('day_name NOT IN (\'Saturday\', \'Sunday\')')
            ->groupBy('map_no, loc_no , factory , location, area, wh_prod')
            ->orderBy('area')
            ->all();
        }

        

        

        return $this->render('temperature-over', [
            'model' => $model,
            'tmp_tbl' => $tmp_tbl,
        ]);
    }
    public function actionWwBeaconLt($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $line_arr = \Yii::$app->params['ww_wip_model'];

        $model = new \yii\base\DynamicModel([
            'line'
        ]);
        $model->addRule(['line'], 'safe');

        if ($model->load($_GET)) {
            # code...
        }

        if ($model->line != '' && $model->line != null) {
            $tmp_model_wip = SernoMaster::find()->select('gmc')->where(['line' => $model->line])->all();
            $gmc_arr = [];
            foreach ($tmp_model_wip as $key => $value) {
                $gmc_arr[] = $value->gmc;
            }

            $tmp_beacon_tbl = BeaconTbl::find()
            ->where('lot_number IS NOT NULL')
            ->andWhere(['parent' => $gmc_arr])
            ->orderBy('start_date')
            ->all();
        } else {
            $tmp_beacon_tbl = BeaconTbl::find()
            ->where('lot_number IS NOT NULL')
            ->orderBy('start_date')
            ->all();
        }

        $tmp_data = $data = [];
        foreach ($tmp_beacon_tbl as $key => $value) {
            $tgl1 = strtotime($value->start_date);
            $tgl2 = strtotime($now);
            $balance_s = $tgl2 - $tgl1;
            $balance_d = round($balance_s / (24 * 3600), 1);
            $color = 'rgb(0, 255, 0)';
            if ($balance_d >= 5) {
                $color = 'rgb(255, 0, 0)';
            }
            $categories[] = $value->model_group . ' - ' . $value->gmc_desc . ' (' . $value->gmc . ') ' . $value->lot_qty . ' PCS [Beacon ID : ' . $value->minor . ']';
            $tmp_data[] = [
                'y' => (float)$balance_d,
                'color' => $color
            ];
        }
        $data[] = [
            'name' => 'WW Beacon LT',
            'data' => $tmp_data
        ];

        return $this->render('ww-beacon-lt', [
            'data' => $data,
            'line_arr' => $line_arr,
            'model' => $model,
            'categories' => $categories
        ]);
    }

    /*public function getWipModelGroupId($model_group, $gmc)
    {
        $tmp_model_id = 'OTHERS';
        foreach ($model_group as $key => $value) {
            if ($value->gmc == $gmc) {
                $tmp_model_id = $value->category_id;
            }
        }

        return $tmp_model_id;
        # code...
    }*/

    public function actionWipControl3()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $tmp_beacon = BeaconTbl::find()
        ->where('lot_number IS NOT NULL')
        ->all();
        $now = date('Y-m-d H:i:s');

        $l_series_qty1 = $l_series_qty2 = $hs_series_qty1 = $hs_series_qty2 = $p40_series_qty1 = $p40_series_qty2 = $others_qty1 = $others_qty2 = $xxx_series_qty1 = $xxx_series_qty2 = 0;
        $tmp_time_arr = [];
        foreach ($tmp_beacon as $key => $value) {
            $waktu1 = strtotime($value->start_date);
            $waktu2 = strtotime($now);
            $waktu_balance_s = $waktu2 - $waktu1;
            $limit_s = 24 * 3600;
            $tmp_time_arr[] = [
                'beacon_id' => $value->minor,
                'start' => $value->start_date,
                'end' => $now,
                'second' => $waktu_balance_s,
                'limit' => $limit_s
            ];
            $tmp_model_group = SernoMaster::find()->where(['gmc' => $value->parent])->one();
            if ($waktu_balance_s <= $limit_s) {
                if ($tmp_model_group->line == 'HS') {
                    $hs_series_qty1 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'L85') {
                    $l_series_qty1 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'P-40') {
                    $p40_series_qty1 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'XXX') {
                    $xxx_series_qty1 += $value->lot_qty;
                } else {
                    $others_qty1 += $value->lot_qty;
                }
            } else {
                if ($tmp_model_group->line == 'HS') {
                    $hs_series_qty2 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'L85') {
                    $l_series_qty2 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'P40') {
                    $p40_series_qty2 += $value->lot_qty;
                } elseif ($tmp_model_group->line == 'XXX') {
                    $xxx_series_qty2 += $value->lot_qty;
                } else {
                    $others_qty2 += $value->lot_qty;
                }
            }
        }

        $data = [
            'hs1' => $hs_series_qty1,
            'hs2' => $hs_series_qty2,
            'l1' => $l_series_qty1,
            'l2' => $l_series_qty2,
            'p40_1' => $p40_series_qty1,
            'p40_2' => $p40_series_qty2,
            'others1' => $others_qty1,
            'others2' => $others_qty2,
            'xxx_1' => $xxx_series_qty1,
            'xxx_2' => $xxx_series_qty2,
        ];

        return $this->render('wip-control3', [
            'data' => $data,
            'tmp_time_arr' => $tmp_time_arr
        ]);
    }

    public function actionWipControl2($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $total_wip = 0;

        $tmp_qty = WwStockWaitingProcess02Open::find()
        ->all();

        $tmp_qty_arr = [];
        
        $qty_series = [
            'hs_series' => 0,
            'l_series' => 0,
            'p40_series' => 0,
            'others' => 0
        ];

        foreach ($tmp_qty as $key => $value) {
            $tmp_qty_arr[$value->kelompok] += $value->lot_qty;
            $total_wip += $value->lot_qty;
            $tmp_model_group = SernoMaster::find()->where(['gmc' => $value->parent])->one();
            if ($tmp_model_group->line == 'HS') {
                $qty_series['hs_series'] += $value->lot_qty;
            } elseif ($tmp_model_group->line == 'L85') {
                $qty_series['l_series'] += $value->lot_qty;
            } elseif ($tmp_model_group->line == 'P40') {
                $qty_series['p40_series'] += $value->lot_qty;
            } elseif ($tmp_model_group->line == 'XXX') {
                $qty_series['xxx_series'] += $value->lot_qty;
            } else {
                $qty_series['others'] += $value->lot_qty;
            }
        }

        $tmp_ewip = WipEffTbl::find()
        ->where([
            'child_analyst' => 'WW02',
            'jenis_mesin' => 'END',
        ])
        ->andWhere(['>', 'plan_date', date('Y-m-d', strtotime(' -15 days'))])
        ->all();

        $tmp_hdr_dtr = WipHdrDtr::find()
        ->where([
            'child_analyst' => 'WW02',
            'stage' => '03-COMPLETED'
        ])
        ->andWhere(['>=', 'source_date', date('Y-m-d', strtotime(' -1 month'))])
        ->all();

        $tmp_qty = 0;
        foreach ($tmp_hdr_dtr as $key => $hdr_dtr) {
            foreach ($tmp_ewip as $key => $ewip) {
                switch ($hdr_dtr->slip_id) {
                    case $ewip->slip_id_01:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_02:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_03:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_04:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_05:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_06:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_07:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_08:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_09:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    case $ewip->slip_id_10:
                        $tmp_qty += ($hdr_dtr->act_qty - $hdr_dtr->balance_by_day_2);
                        break;
                    default:
                        # code...
                        break;
                }
            }
        }

        $data = [
            'running_saw' => isset($tmp_qty_arr['RSAW']) ? $tmp_qty_arr['RSAW'] : 0,
            //'running_saw' => 2000,
            'det' => isset($tmp_qty_arr['DET']) ? $tmp_qty_arr['DET'] : 0,
            'end' => $tmp_qty,
            'total_wip' => $total_wip
        ];

        return $this->render('wip-control2', [
            'data' => $data,
            'qty_series' => $qty_series,
        ]);
    }
    public function actionDandoriPlanMonitoring()
    {
        $this->layout = 'clean';
        $data = [];
        $location = 'WM03';
        $location_dropdown = ArrayHelper::map(WipLocation::find()->select('child_analyst, child_analyst_desc')->groupBy('child_analyst, child_analyst_desc')->orderBy('child_analyst_desc')->all(), 'child_analyst', 'child_analyst_desc');

        if(\Yii::$app->request->get('location') !== null){
            $location = \Yii::$app->request->get('location');
        }

        $tmp_wip_eff_tbl = WipEffTbl::find()->where([
            'child_analyst' => $location,
            'plan_stats' => 'O',
            'plan_run' => 'N'
        ])
        ->andWhere(['<>', 'ext_dandori_status', 3])
        ->orderBy('LINE, SMT_SHIFT')
        ->all();

        foreach ($tmp_wip_eff_tbl as $key => $value) {
            $data[$value->ext_dandori_status][] = [
                'line' => $value->LINE,
                'lot_no' => $value->lot_id,
                'part_no' => $value->child_all,
                'part_desc' => $value->child_desc_all,
                'qty' => $value->qty_all,
                'dandori_status' => $value->ext_dandori_status
            ];
        }

        if ($tmp_wip_eff_tbl) {
            $no_plan = false;
        } else {
            $no_plan = true;
        }

        return $this->render('dandori-plan-monitoring', [
            'model' => $model,
            'data' => $data,
            'no_plan' => $no_plan,
            'location' => $location,
            'location_dropdown' => $location_dropdown,
        ]);
    }
    public function actionPchKanban($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];

        $model = new \yii\base\DynamicModel([
            'kanban_period'
        ]);
        $model->addRule(['kanban_period'], 'required');

        if ($model->load($_GET)) {
            $tmp_log = KanbanPchLog::find()
            ->select([
                'last_update' => 'FORMAT(last_update, \'yyyy-MM-dd\')',
                'count_stat' => 'SUM(count_stat)',
                'in_progress' => 'SUM(in_progress)',
                'done' => 'SUM(done)',
            ])
            ->where([
                'period' => $model->kanban_period
            ])
            ->groupBy('last_update')
            ->orderBy('last_update')
            ->all();

            foreach ($tmp_log as $key => $value) {
                $proddate = (strtotime($value->last_update . " +7 hours") * 1000);
                $tmp_data_total[] = [
                    'x' => $proddate,
                    'y' => (int)$value->count_stat
                ];
                $tmp_data_progress[] = [
                    'x' => $proddate,
                    'y' => (int)$value->in_progress
                ];
                $tmp_data_done[] = [
                    'x' => $proddate,
                    'y' => (int)$value->done
                ];
            }
        }

        $data = [
            [
                'name' => 'Total',
                'data' => $tmp_data_total,
            ],
            [
                'name' => 'Done',
                'data' => $tmp_data_done,
            ],
            [
                'name' => 'In Progress',
                'data' => $tmp_data_progress,
            ],
            
        ];

        return $this->render('pch-kanban', [
            'data' => $data,
            'model' => $model,
        ]);
    }
    public function actionSmtStockWip($loc = 'WM03')
    {
        $this->layout = 'clean';


        $wip_stock_delay = $this->getWipStockDelay($loc);

        $tgl_arr = [
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 day')),
            date('Y-m-d', strtotime('+2 days'))
        ];

        $stock_arr = [];

        $tmp_stock_delay1 = $this->getWipStockDelay($loc, $tgl_arr[0]);
        $stock_arr[] = $tmp_stock_delay1['total_stock'];

        $tmp_stock_delay2 = $this->getWipStockDelay($loc, $tgl_arr[1]);
        $stock_arr[] = $tmp_stock_delay2['total_stock'];

        $tmp_stock_delay3 = $this->getWipStockDelay($loc);
        $stock_arr[] = $tmp_stock_delay3['total_stock'] - ($tmp_stock_delay1['total_stock'] + $tmp_stock_delay2['total_stock']);

        return $this->render('smt-stock-wip', [
            'target_stock' => 6000,
            'total_stock' => $wip_stock_delay['total_stock'],
            'tgl_arr' => $tgl_arr,
            'loc' => $loc,
            'stock_arr' => $stock_arr,
        ]);
    }

    public function actionOnhandNice($value='')
    {
        $this->layout = 'clean';
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {
            # code...
        }

        $tmp_onhand = OnhandNice::find()
        ->select([
            'LAST_UPDATE',
            'ONHAND_QTY' => 'SUM(ONHAND_QTY)',
            'TOT_M3' => 'SUM(TOT_M3)'
        ])
        ->where([
            'AND',
            ['>=', 'FORMAT(LAST_UPDATE, \'yyyy-MM-dd\')', $model->from_date],
            ['<=', 'FORMAT(LAST_UPDATE, \'yyyy-MM-dd\')', $model->to_date]
        ])
        ->groupBy('LAST_UPDATE')
        ->orderBy('LAST_UPDATE')
        ->all();

        $tmp_data_qty = $tmp_data_m3 = [];
        foreach ($tmp_onhand as $key => $value) {
            $proddate = (strtotime($value->LAST_UPDATE . " +7 hours") * 1000);
            $tmp_data_qty[] = [
                'x' => $proddate,
                'y' => $value->ONHAND_QTY
            ];
            $tmp_data_m3[] = [
                'x' => $proddate,
                'y' => round($value->TOT_M3, 1)
            ];
        }

        $data_qty[] = [
            'name' => 'Total Qty',
            'data' => $tmp_data_qty
        ];

        $data_m3[] = [
            'name' => 'Total M3',
            'data' => $tmp_data_m3
        ];

        return $this->render('onhand-nice', [
            'model' => $model,
            'data_qty' => $data_qty,
            'data_m3' => $data_m3,
        ]);
    }

    public function getSprAoi()
    {
        $return_arr = [];
        $masalah_pcb = MasalahSmt::find()->select([
            'total_ng' => 'SUM(qty_smt)'
        ])
        ->where(['date(created_date)' => date('Y-m-d')])
        ->groupBy('date(created_date)')
        ->one();
        $total_ng = $masalah_pcb->total_ng;

        $output_smt = SprOut::find()
        ->select([
            'qty_sprout' => 'SUM(qty_sprout)'
        ])
        ->where(['date_sprout' => date('Y-m-d')])
        ->groupBy('date_sprout')
        ->one();
        $total_output = $output_smt->qty_sprout;

        $spr_aoi = 0;
        if ($total_output > 0) {
            $spr_aoi = round((($total_output - $total_ng) / $total_output) * 100, 1);
        }
        $return_arr[] = $spr_aoi;

        $masalah_pcb = MasalahSmt::find()->select([
            'total_ng' => 'SUM(qty_smt)'
        ])
        ->where(['EXTRACT(year_month FROM created_date)' => date('Ym')])
        ->groupBy('EXTRACT(year_month FROM created_date)')
        ->one();
        $total_ng = $masalah_pcb->total_ng;

        $output_smt = SprOut::find()
        ->select([
            'qty_sprout' => 'SUM(qty_sprout)'
        ])
        ->where(['EXTRACT(year_month FROM date_sprout)' => date('Ym')])
        ->groupBy('EXTRACT(year_month FROM date_sprout)')
        ->one();
        $total_output = $output_smt->qty_sprout;

        $spr_aoi = 0;
        if ($total_output > 0) {
            $spr_aoi = round((($total_output - $total_ng) / $total_output) * 100, 1);
        }

        $return_arr[] = $spr_aoi;
        return $return_arr;
    }

    public function getInternalDandori($location, $line = '')
    {
        $return_arr = [];
        if ($line == '') {
            $dandori_data = WipEff03Dandori05::find()
            ->select([
                'child_analyst',
                'dandori_second' => 'SUM(dandori_second)',
                'SHIFT_TIME' => 'SUM(SHIFT_TIME)',
                'lost_etc' => 'SUM(lost_etc)'
            ])
            ->where([
                'child_analyst' => $location,
                'CONVERT(date, post_date)' => date('Y-m-d')
            ])
            ->groupBy('child_analyst')
            ->one();

            $dandori_data_monthly = WipEff03Dandori05::find()
            ->select([
                'child_analyst',
                'dandori_second' => 'SUM(dandori_second)',
                'SHIFT_TIME' => 'SUM(SHIFT_TIME)',
                'lost_etc' => 'SUM(lost_etc)'
            ])
            ->where([
                'child_analyst' => $location,
                'FORMAT(post_date, \'yyyyMM\')' => date('Ym')
            ])
            ->groupBy('child_analyst')
            ->one();
        } else {
            $dandori_data = WipEff03Dandori05::find()
            ->select([
                'child_analyst',
                'dandori_second' => 'SUM(dandori_second)',
                'SHIFT_TIME' => 'SUM(SHIFT_TIME)',
                'lost_etc' => 'SUM(lost_etc)'
            ])
            ->where([
                'child_analyst' => $location,
                'CONVERT(date, post_date)' => date('Y-m-d'),
                'LINE' => $line
            ])
            ->groupBy('child_analyst')
            ->one();

            $dandori_data_monthly = WipEff03Dandori05::find()
            ->select([
                'child_analyst',
                'dandori_second' => 'SUM(dandori_second)',
                'SHIFT_TIME' => 'SUM(SHIFT_TIME)',
                'lost_etc' => 'SUM(lost_etc)',
            ])
            ->where([
                'child_analyst' => $location,
                'FORMAT(post_date, \'yyyyMM\')' => date('Ym'),
                'LINE' => $line
            ])
            ->groupBy('child_analyst')
            ->one();
        }
        $dandori_pct = 0;
        if (($dandori_data->SHIFT_TIME - $dandori_data->lost_etc) > 0) {
            $dandori_pct = round(($dandori_data->dandori_second / ($dandori_data->SHIFT_TIME - $dandori_data->lost_etc)) * 100);
        }
        
        $return_arr[] = $dandori_pct;

        $dandori_pct_monthly = 0;
        if (($dandori_data_monthly->SHIFT_TIME - $dandori_data_monthly->lost_etc) > 0) {
            $dandori_pct_monthly = round(($dandori_data_monthly->dandori_second / ($dandori_data_monthly->SHIFT_TIME - $dandori_data_monthly->lost_etc)) * 100); 
        }
        
        $return_arr[] = $dandori_pct_monthly;

        return $return_arr;
    }

    public function getWipStockDelay($location = '', $tgl = '', $other = '')
    {
        if ($tgl == '') {
            $wip_data = WipHdrDtr::find()
            ->select([
                'child_analyst',
                'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
            ])
            ->where([
                'child_analyst' => $location
            ])
            ->andWhere(['>=', 'post_date', '2019-12-01'])
            ->groupBy('child_analyst')
            ->one();
        } else {
            if ($other == 'other') {
               $wip_data = WipHdrDtr::find()
                ->select([
                    'child_analyst',
                    'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                    'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                    'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                ])
                ->where([
                    'child_analyst' => $location,
                    'source_date' => $tgl
                ])
                ->andWhere(['>=', 'source_date', $tgl])
                ->andWhere(['<', 'due_date', date('Y-m-d')])
                ->andWhere(['>=', 'post_date', '2019-12-01'])
                ->groupBy('child_analyst')
                ->one();
            } else {
                 $wip_data = WipHdrDtr::find()
                ->select([
                    'child_analyst',
                    'total_order' => 'SUM(CASE WHEN stage=\'00-ORDER\' OR stage=\'01-CREATED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                    'total_started' => 'SUM(CASE WHEN stage=\'02-STARTED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                    'total_completed' => 'SUM(CASE WHEN stage=\'03-COMPLETED\' THEN (act_qty - balance_by_day_2) ELSE 0 END)',
                ])
                ->where([
                    'child_analyst' => $location,
                    'source_date' => $tgl
                ])
                ->andWhere(['<', 'due_date', date('Y-m-d')])
                ->andWhere(['>=', 'post_date', '2019-12-01'])
                ->groupBy('child_analyst')
                ->one();
            }
            
        }
        

        $total_delay = ($wip_data->total_order) * -1;
        $total_stock = ($wip_data->total_started + $wip_data->total_completed);

        return [
            'total_delay' => $total_delay,
            'total_stock' => $total_stock
        ];
    }

    public function getCurrentModel($location = '', $line = '')
    {
        //$today = '2019-11-22';
        //$today = date('Y-m-d');
        $data = $tmp_data = [];

        $tmp_wip = WipEffTbl::find()
        ->where([
            'child_analyst' => $location,
            'LINE' => $line,
            //'plan_date' => $today,
            'plan_stats' => 'O',
            'plan_run' => 'N'
        ])
        ->orderBy('lot_id')
        ->one();

        $tmp_data = [
            'model_group' => $tmp_wip->model_group,
            'parent_desc' => $tmp_wip->parent_desc,
            'child_desc' => $tmp_wip->child_desc_all,
            'status' => $tmp_wip->ext_dandori_status,
            'qty' => $tmp_wip->qty_all,
            'kondisi' => $kondisi
        ];

        return $tmp_data;
    }

    public function actionSmtInjToday($loc = '',$line='01')
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $location = 'WM03';
        $location_str = 'SMT';
        if ($loc != '') {
            $location = $loc;
            $tmp_loc = WipLocation::find()->where(['child_analyst' => $location])->one();
            $location_str = $tmp_loc->child_analyst_desc;
        }

        $dandori_pct = $this->getInternalDandori($location, $line);

        $wip_stock_delay = $this->getWipStockDelay($location);

        //$spr_aoi = $this->getSprAoi();

        $ext_dandori_current = $this->getCurrentModel($location, $line);

        $tmp_target_actual = WipEffTbl::find()
        ->select([
            'plan_date',
            'target_qty' => 'SUM(qty_all)',
            'actual_qty' => 'SUM(CASE WHEN plan_stats = \'C\' THEN qty_all ELSE 0 END)'
        ])
        ->where([
            'child_analyst' => $location,
            'LINE' => $line,
            'plan_date' => date('Y-m-d')
        ])
        ->groupBy('plan_date')
        ->one();
        $prod_target_actual = [
            'plan' => (int)$tmp_target_actual->target_qty,
            'actual' => (int)$tmp_target_actual->actual_qty,
            'balance' => (int)($tmp_target_actual->actual_qty - $tmp_target_actual->target_qty)
        ];

        return $this->render('smt-inj-today', [
            'dandori_pct' => $dandori_pct,
            'spr_aoi' => $spr_aoi,
            'total_delay' => $wip_stock_delay['total_delay'],
            'total_stock' => $wip_stock_delay['total_stock'],
            'line' => $line,
            'location_str' => $location_str,
            'ext_dandori_current' => $ext_dandori_current,
            'prod_target_actual' => $prod_target_actual,
        ]);
    }
    public function actionVisitorRfidView($visitor_name = '', $visitor_company = '')
    {
        $this->layout = 'clean';
        return $this->render('visitor-rfid-view', [
            'visitor_name' => $visitor_name,
            'visitor_company' => $visitor_company,
        ]);
    }

    public function actionVisitorRfid()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $is_alert = 1;

        $model = new \yii\base\DynamicModel([
            'rfid_no'
        ]);
        $model->addRule(['rfid_no'], 'string');
        $visitor_name = '';

        if ($model->load($_POST)) {
            if ($model->rfid_no != null && $model->rfid_no != '') {
                $visitor = Visitor::find()->where([
                    'date(tgl)' => date('Y-m-d')
                ]);
                $visitor = $visitor->andFilterWhere(['like', 'card', $model->rfid_no])->orderBy('tgl DESC')->one();
                if ($visitor->pk) {
                    $visitor_name = $visitor->visitor_name;
                    return $this->redirect(Url::to(['visitor-rfid-view', 'visitor_name' => $visitor_name, 'visitor_company' => $visitor->visitor_comp]));
                }
            }
            $model->rfid_no = '';
        }

        return $this->render('visitor-rfid', [
            'model' => $model,
            'is_alert' => $is_alert,
            'visitor_name' => $visitor_name,
        ]);
    }

    function actionSubAssyDriverUtility()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $post_date = date('Y-m-d');
        $location_arr = ['PANGKALAN', 'SUB-ASSY-NETWORK', 'SUB-ASSY-FRONT-GRILL', 'SUB-ASSY-ACCESORIES'];
        $tmp_operator = GojekTbl::find()
        ->where([
            'SOURCE' => 'SUB',
            'HADIR' => 'Y'
        ])
        ->orderBy('GOJEK_DESC')
        ->all();

        $tmp_order = GojekOrderTbl::find()
        ->where([
            'source' => 'SUB',
            'FORMAT(post_date, \'yyyy-MM-dd\')' => $post_date
        ])
        ->andWhere('daparture_date IS NOT NULL')
        ->all();

        $tmp_data = [];
        foreach ($tmp_operator as $driver) {
            $lt = 0;
            foreach ($tmp_order as $value) {
                if ($value->GOJEK_ID == $driver->GOJEK_ID) {
                    if ($value->LT != null) {
                        $lt += $value->LT;
                    } else {
                        $lt += GeneralFunction::instance()->getWorkingTime($value->daparture_date, date('Y-m-d H:i:s'));
                    }
                    
                }
            }
            $tmp_data[$driver->GOJEK_ID] = $lt;
        }

        $data = [];
        foreach ($location_arr as $key => $location) {
            $operator_arr = [];
            foreach ($tmp_operator as $key => $operator) {
                if ($operator->beacon_location == $location) {
                    $utility = 0;
                    $tmp_lt = (int)$tmp_data[$operator->GOJEK_ID];

                    if ($tmp_lt > 0) {
                        $utility = round(($tmp_lt / 480) * 100, 1);
                    }
                    
                    $operator_arr[] = [
                        'nik' => $operator->GOJEK_ID,
                        'name' => $operator->GOJEK_DESC,
                        'utility' => $utility
                    ];
                }
            }
            $data[$location]['operator'] = $operator_arr;
        }

        return $this->render('sub-assy-driver-utility', [
            'location_arr' => $location_arr,
            'data' => $data,
            'tmp_data' => $tmp_data,
        ]);
    }

    public function actionLotTimeline()
    {
        $this->layout = 'clean';
        $data = [];
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'model_group', 'from_date', 'to_date', 'beacon_using', 'wip_location'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required')
        ->addRule(['model_group', 'beacon_using', 'wip_location'], 'safe');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        $model->beacon_using = 1;
        $model->wip_location = 'WW02';
        $location_arr = \Yii::$app->params['wip_location_arr'];
        if (count($location_arr) > 0) {
            asort($location_arr);
        }

        if ($model->load($_GET)) {
            # code...
        }

        if ($model->model_group != '' && $model->model_group != null) {
            $tmp_model_wip = SernoMaster::find()->select('gmc')->where(['line' => $model->model_group])->all();
            $gmc_arr = [];
            foreach ($tmp_model_wip as $key => $value) {
                $gmc_arr[] = $value->gmc;
            }

            if ($model->wip_location == 'WW02') {
                $tmp_beacon_arr = BeaconTblTrack::find()
                ->select([
                    'upload_date',
                    'total_lot' => 'SUM(CASE WHEN lot_qty > 0 THEN 1 ELSE 0 END)',
                    'total_qty' => 'SUM(lot_qty)'
                ])
                ->where([
                    'AND',
                    ['>=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->from_date],
                    ['<=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->to_date]
                ])
                ->andWhere(['parent' => $gmc_arr])
                ->andWhere('minor IS NOT NULL')
                ->groupBy('upload_date')
                ->orderBy('upload_date')
                ->all();
            } else {
                $tmp_beacon_arr = BeaconTblTrack::find()
                ->select([
                    'upload_date',
                    'total_lot' => 'SUM(CASE WHEN lot_qty > 0 THEN 1 ELSE 0 END)',
                    'total_qty' => 'SUM(lot_qty)'
                ])
                ->where([
                    'AND',
                    ['>=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->from_date],
                    ['<=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->to_date]
                ])
                ->andWhere([
                    'parent' => $gmc_arr,
                    'mesin_id' => $model->wip_location
                ])
                ->groupBy('upload_date')
                ->orderBy('upload_date')
                ->all();
            }
            
        } else {
            if ($model->wip_location == 'WW02') {
                $tmp_beacon_arr = BeaconTblTrack::find()
                ->select([
                    'upload_date',
                    'total_lot' => 'SUM(CASE WHEN lot_qty > 0 THEN 1 ELSE 0 END)',
                    'total_qty' => 'SUM(lot_qty)'
                ])
                ->where([
                    'AND',
                    ['>=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->from_date],
                    ['<=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->to_date]
                ])
                ->andWhere('minor IS NOT NULL')
                ->groupBy('upload_date')
                ->orderBy('upload_date')
                ->all();
            } else {
                $tmp_beacon_arr = BeaconTblTrack::find()
                ->select([
                    'upload_date',
                    'total_lot' => 'SUM(CASE WHEN lot_qty > 0 THEN 1 ELSE 0 END)',
                    'total_qty' => 'SUM(lot_qty)'
                ])
                ->where([
                    'AND',
                    ['>=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->from_date],
                    ['<=', 'FORMAT(upload_date, \'yyyy-MM-dd\')', $model->to_date]
                ])
                ->andWhere([
                    'mesin_id' => $model->wip_location
                ])
                ->groupBy('upload_date')
                ->orderBy('upload_date')
                ->all();
            }
            
        }

        

        $tmp_data_qty = $tmp_data_lot = [];
        foreach ($tmp_beacon_arr as $key => $value) {
            $proddate = (strtotime($value->upload_date . " +7 hours") * 1000);
            $tmp_data_lot[] = [
                'x' => $proddate,
                'y' => (int)$value->total_lot
            ];
            $tmp_data_qty[] = [
                'x' => $proddate,
                'y' => (int)$value->total_qty
            ];
        }

        $data_lot = [
            [
                'name' => 'Total Lot by Hours',
                'data' => $tmp_data_lot,
                //'showInLegend' => false
            ],
        ];

        $data_qty = [
            [
                'name' => 'Total Qty by Hours',
                'data' => $tmp_data_qty,
                //'showInLegend' => false
            ],
        ];

        return $this->render('lot-timeline', [
            'model' => $model,
            'location_arr' => $location_arr,
            'data_lot' => $data_lot,
            'data_qty' => $data_qty,
        ]);
    }

    public function actionWwBeaconShipping($minor = '')
    {
        $this->layout = 'clean';
        $beacon_data = BeaconWipView::find()->where(['minor' => $minor])->one();
        $start_time = '-';
        if ($beacon_data->start_date != null) {
            $start_time = date('d M\' Y H:i', strtotime($beacon_data->start_date));
        }

        $lot_data = WipEffTbl::find()
        ->where([
            'lot_id' => $beacon_data->lot_number,
        ])
        ->one();

        $slip_id_arr = [
            $lot_data->slip_id_01,
            $lot_data->slip_id_02,
            $lot_data->slip_id_03,
            $lot_data->slip_id_04,
            $lot_data->slip_id_05,
            $lot_data->slip_id_06,
            $lot_data->slip_id_07,
            $lot_data->slip_id_08,
            $lot_data->slip_id_09,
            $lot_data->slip_id_10
        ];

        sort($slip_id_arr);

        $slip_no_txt = '';
        $slip_no_qty = $lot_data->slip_count;
        $hdr_id_arr = [];
        $tmp_slip_id = [];
        foreach ($slip_id_arr as $key => $value) {
            if ($value != null) {
                $tmp_slip_id[] = $value;
                if ($slip_no_txt == '') {
                    $slip_no_txt .= $value;
                } else {
                    $slip_no_txt .= ', ' . $value;
                }
            }
        }

        $tmp_hdr_dtr = WipHdrDtr::find()
        ->where([
            'child_analyst' => 'WW02',
            'slip_id' => $tmp_slip_id
        ])
        ->asArray()
        ->all();

        $tmp_hdr_dtr_txt = '';
        $tmp_fa_date = [];
        foreach ($tmp_hdr_dtr as $key => $value) {
            if (!in_array($value['hdr_id'], $hdr_id_arr)) {
                $hdr_id_arr[] = $value['hdr_id'];
            }
            
            if ($tmp_hdr_dtr_txt == '') {
                $tmp_hdr_dtr_txt = $value['hdr_id'];
            } else {
                $tmp_hdr_dtr_txt .= ', ' . $value['hdr_id'];
            }
            if ($value['stat'] == 'O') {
                $tmp_fa_date[] = $value['source_date'];
            }
            
        }

        $serno_output_data = SernoOutput::find()
        ->where([
            'num' => $hdr_id_arr
        ])
        ->orderBy('etd')
        ->all();

        //$datetime1 = strtotime($beacon_data->start_date);
        $datetime1 = $beacon_data->start_date;

        $tmp_first_date = [];
        foreach ($serno_output_data as $key => $value) {
            if ($value->qty != $value->output) {
                $tmp_first_date[] = $value->etd;
            }
            
        }
        sort($tmp_first_date);
        $nearest_shipping_date = '-';
        $lt_to_shipping = '-';
        if (count($tmp_first_date) > 0) {
            $nearest_shipping_date = $tmp_first_date[0];
            //$datetime2 = strtotime($nearest_shipping_date . ' 07:00:00');
            $datetime2 = $nearest_shipping_date;
            $diff_seconds = $datetime2 - $datetime1;
            //$diff_day = round(($diff_seconds / (3600 * 24)), 1);
            $diff_day = (new \DateTime(date('Y-m-d', strtotime($datetime1))))->diff(new \DateTime(date('Y-m-d', strtotime($datetime2))))->days;
            if ($diff_day > 1) {
                $lt_to_shipping = $diff_day . ' days';
            } else {
                $lt_to_shipping = $diff_day . ' day';
            }
        }
        sort($tmp_fa_date);
        $nearest_fa_date = '-';
        $lt_to_fa = '-';
        if (count($tmp_fa_date) > 0) {
            $nearest_fa_date = date('Y-m-d', strtotime($tmp_fa_date[0]));
            //$datetime2 = strtotime($nearest_fa_date . ' 07:00:00');
            $datetime2 = $nearest_fa_date;
            $diff_seconds = $datetime2 - $datetime1;
            //$diff_day = round(($diff_seconds / (3600 * 24)), 1);
            $diff_day = (new \DateTime(date('Y-m-d', strtotime($datetime1))))->diff(new \DateTime(date('Y-m-d', strtotime($datetime2))))->days;
            if ($diff_day > 1) {
                $lt_to_fa = $diff_day . ' days';
            } else {
                $lt_to_fa = $diff_day . ' day';
            }
        }

        $lt_current = (new \DateTime(date('Y-m-d', strtotime($datetime1))))->diff(new \DateTime(date('Y-m-d')))->days;;

        return $this->render('ww-beacon-shipping', [
            'beacon_data' => $beacon_data,
            'start_time' => $start_time,
            'slip_no_txt' => $slip_no_txt,
            'slip_no_qty' => $slip_no_qty,
            'serno_output_data' => $serno_output_data,
            'nearest_shipping_date' => $nearest_shipping_date,
            'tmp_hdr_dtr_txt' => $tmp_hdr_dtr_txt,
            'nearest_fa_date' => $nearest_fa_date,
            'lt_to_shipping' => $lt_to_shipping,
            'lt_to_fa' => $lt_to_fa,
            'lt_current' => $lt_current,
        ]);
    }

    public function actionGetBeaconDetail($minor = '')
    {
        $beacon_data = BeaconTbl::find()->where(['minor' => $minor])->one();

        $data = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Beacon ID : ' . $minor . '</h3>
        </div>
        <div class="modal-body">
        ';

        $start_time = '-';
        if ($beacon_data->start_date != null) {
            $start_time = date('d M\' Y H:i', strtotime($beacon_data->start_date));
        }

        $lot_data = WipEffTbl::find()
        ->where([
            'lot_id' => $beacon_data->lot_number,
        ])
        ->one();

        $slip_id_arr = [
            $lot_data->slip_id_01,
            $lot_data->slip_id_02,
            $lot_data->slip_id_03,
            $lot_data->slip_id_04,
            $lot_data->slip_id_05,
            $lot_data->slip_id_06,
            $lot_data->slip_id_07,
            $lot_data->slip_id_08,
            $lot_data->slip_id_09,
            $lot_data->slip_id_10
        ];

        sort($slip_id_arr);

        $slip_no_txt = '';
        $slip_no_qty = $lot_data->slip_count;
        $hdr_id_arr = [];
        $tmp_slip_id = [];
        foreach ($slip_id_arr as $key => $value) {
            if ($value != null) {
                $tmp_slip_id[] = $value;
                if ($slip_no_txt == '') {
                    $slip_no_txt .= $value;
                } else {
                    $slip_no_txt .= ', ' . $value;
                }
            }
        }

        $tmp_hdr_dtr = WipHdrDtr::find()
        ->select('hdr_id')
        ->where([
            'child_analyst' => 'WW02',
            'slip_id' => $tmp_slip_id
        ])
        ->groupBy('hdr_id')
        ->all();

        foreach ($tmp_hdr_dtr as $key => $value) {
            $hdr_id_arr[] = $value['hdr_id'];
        }

        $tmp_serno_output = SernoOutput::find()
        ->where([
            'num' => $hdr_id_arr
        ])
        ->orderBy('etd')
        ->asArray()
        ->all();

        $data .= '<dl class="dl-horizontal">
            <dt>Lot Number : </dt>
            <dd>' . $beacon_data->lot_number . '</dd>
            <dt>Start Time (First Process) : </dt>
            <dd>' . $start_time . '</dd>
            <dt>Model : </dt>
            <dd>' . $beacon_data->model_group . '</dd>
            <dt>Part Number : </dt>
            <dd>' . $beacon_data->gmc . '</dd>
            <dt>Part Name : </dt>
            <dd>' . $beacon_data->gmc_desc . '</dd>
            <dt>Qty : </dt>
            <dd>' . $beacon_data->lot_qty . '</dd>
            <dt>Machine ID : </dt>
            <dd>' . $beacon_data->mesin_id . '</dd>
            <dt>Machine Desc. : </dt>
            <dd>' . $beacon_data->mesin_description . '</dd>
            <dt>Slip Number (' . $slip_no_qty . ') : </dt>
            <dd>' . $slip_no_txt . '</dd>
        </dl>';

        $data .= '<table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">ETD</th>
                    <th>Port</th>
                    <th class="text-center">Container No.</th>
                    <th class="text-center">GMC</th>
                    <th class="text-center">Plan Qty</th>
                    <th class="text-center">Actual Qty</th>
                    <th class="text-center">Balance Qty</th>
                </tr>
            </thead>
            <tbody>';

        $total_qty = $total_output = $total_balance = 0;
        if (count($tmp_serno_output) > 0) {
            
            foreach ($tmp_serno_output as $key => $value) {
                $balance = $value['output'] - $value['qty'];
                $total_qty += $value['qty'];
                $total_output += $value['output'];
                $total_balance += $balance;
                $data .= '<tr>
                    <td class="text-center">' . $value['etd'] . '</td>
                    <td>' . $value['dst'] . '</td>
                    <td class="text-center">' . $value['cntr'] . '</td>
                    <td class="text-center">' . $value['gmc'] . '</td>
                    <td class="text-center">' . $value['qty'] . '</td>
                    <td class="text-center">' . $value['output'] . '</td>
                    <td class="text-center">' . $balance . '</td>
                </tr>';
            }
        } else {
            $data .= '<tr>
                <td colspan="7">No shipping data connection ...</td>
            </tr>';
        }
        

        $data .= '</tbody>
            <tfoot>
                <tr class="info" style="font-weight: bold;">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-center">' . $total_qty . '</td>
                    <td class="text-center">' . $total_output . '</td>
                    <td class="text-center">' . $total_balance . '</td>
                </tr>
            </tfoot>
        </table>';

        return $data;
    }

    public function actionWwBeaconLoc()
    {
        $this->layout = 'clean';
        $loc_arr = [
            'PILAR-16I',
            'PILAR-12I',
            'PILAR-10I',
            'PILAR-6I',
        ];

        $tmp_beacon = BeaconWipView::find()
        ->where('lot_number IS NOT NULL')
        ->orderBy('lot_qty DESC')
        ->asArray()
        ->all();

        $lot_number_arr = [];
        foreach ($tmp_beacon as $key => $value) {
            $lot_number_arr[] = $value->lot_number;
        }

        $beacon_data = BeaconWipView::find()
        ->orderBy('minor')
        ->asArray()
        ->all();

        $kelompok_machine = MachineIotCurrent::find()
        ->select('kelompok')
        ->where([
            'AND',
            ['<>', 'kelompok', 'CHM'],
            ['<>', 'kelompok', 'INJ']
        ])
        ->groupBy('kelompok')
        ->orderBy('kelompok')
        ->all();

        $tmp_lot_arr = WipEffTbl::find()
        ->where([
            'lot_id' => $lot_number_arr
        ])
        ->all();

        return $this->render('ww-beacon-loc', [
            'data' => $tmp_beacon,
            'loc_arr' => $loc_arr,
            'beacon_data' => $beacon_data,
            'kelompok_machine' => $kelompok_machine,
        ]);
    }

    public function actionSensorTblDisplay()
    {
        $this->layout = 'clean';

        $model = new \yii\base\DynamicModel([
            'factory'
        ]);
        $model->addRule(['factory'], 'string');
        $model->factory = 'Factory #1';

        if ($model->load($_GET)) {};

        $data = SensorTbl::find()->where([
            'factory' => $model->factory,
            'is_showing' => 1
        ])->orderBy('priority_no, location, area')->asArray()->all();

        return $this->render('sensor-tbl-display', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionLotWaitingDetail($lot_number, $jenis_mesin, $start_date, $end_date, $model_group, $parent_desc, $gmc, $gmc_desc, $mesin_id, $mesin_description, $minor)
    {
        date_default_timezone_set('Asia/Jakarta');
        $lot_flow_link = Html::a($lot_number, ['machine-iot-output-hdr/detail', 'lot_number' => $lot_number]);
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Lot Number : <u>' . $lot_flow_link . '</u> <em style="font-size: 0.8em; color: blue;">(Click lot number to view flow process)</em><small><br/>(Model ' . $model_group . ')<br/>Machine : ' . $mesin_description . ' - ' . $mesin_id . '</small></h3>
        </div>
        <div class="modal-body">
        ';

        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr>
            <th class="text-center" style="width: 90px;">Start Time</th>
            <th class="text-center" style="width: 90px;">End Time</th>
            <th class="text-center" style="width: 90px;">Beacon ID</th>
            <th class="text-center">Part No.</th>
            <th>Part Name</th>
            <th class="text-center">Parent</th>
            <th class="text-center">Next Process</th>
        </tr>';

        $remark .= '<tr>
            <td class="text-center">' . date('Y-m-d H:i', strtotime($start_date)) . '</td>
            <td class="text-center">' . date('Y-m-d H:i', strtotime($end_date)) . '</td>
            <td class="text-center">' . $minor . '</td>
            <td class="text-center">' . $gmc . '</td>
            <td>' . $gmc_desc . '</td>
            <td class="text-center">' . $parent_desc . '</td>
            <td class="text-center">' . $jenis_mesin . '</td>
        </tr>';

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionWwLotWaiting($value='')
    {
        $this->layout = 'clean';

        $model = new \yii\base\DynamicModel([
            'machine_group'
        ]);
        $model->addRule(['machine_group'], 'string');

        if ($model->load($_GET)) {
            if ($model->machine_group != null) {
                $waiting_data_arr = WwStockWaitingProcess02Open::find()
                ->where(['kelompok' => $model->machine_group])
                ->orderBy('hours_waiting DESC')
                ->all();
            } else {
                $waiting_data_arr = WwStockWaitingProcess02Open::find()
                ->orderBy('hours_waiting DESC')
                ->all();
            }
            
        } else {
            $waiting_data_arr = WwStockWaitingProcess02Open::find()
            ->orderBy('hours_waiting DESC')
            ->all();
        }

        

        $categories = $tmp_data = $data = [];
        foreach ($waiting_data_arr as $key => $value) {
            $categories[] = 'Lot - ' . $value->lot_number;
            $tmp_data[] = [
                'y' => round($value->hours_waiting),
                'url' => Url::to(['lot-waiting-detail',
                    'lot_number' => $value->lot_number,
                    'jenis_mesin' => $value->jenis_mesin,
                    'start_date' => $value->start_date,
                    'end_date' => $value->end_date,
                    'model_group' => $value->model_group,
                    'parent_desc' => $value->parent_desc,
                    'gmc' => $value->gmc,
                    'gmc_desc' => $value->gmc_desc,
                    'mesin_id' => $value->mesin_id,
                    'mesin_description' => $value->mesin_description,
                    'minor' => $value->minor,
                ]),
            ];
        }

        $data[] = [
            'name' => 'Time Waiting Next Process',
            'data' => $tmp_data
        ];

        return $this->render('ww-lot-waiting', [
            'data' => $data,
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    public function actionClinicByFreq()
    {
        $this->layout = 'clean';
        $model = new \yii\base\DynamicModel([
            'fiscal'
        ]);
        $model->addRule(['fiscal'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal = $current_fiscal->FISCAL;

        if ($_GET['fiscal'] != null) {
            $model->fiscal = $_GET['fiscal'];
        }

        if ($model->load($_GET)) {
            
        };

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal
        ])
        ->orderBy('PERIOD')
        ->all();
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_visit = KlinikInput::find()
        ->select([
            'dept', 'nik', 'nama',
            'total_minutes' => 'SUM(abs(timestampdiff(MINUTE, masuk, keluar)))',
            'total1' => 'COUNT(pk)'
        ])
        ->where([
            'EXTRACT(year_month FROM pk)' => $period_arr
        ])
        ->andWhere(['<>', 'opsi', 3])
        ->andWhere('keluar IS NOT NULL')
        ->groupBy('dept, nik, nama')
        ->orderBy('total1 DESC, nama')
        ->all();

        return $this->render('clinic-by-freq', [
            'model' => $model,
            'data' => $tmp_visit
        ]);
    }

    public function actionClinicByMin()
    {
        $this->layout = 'clean';
        $model = new \yii\base\DynamicModel([
            'fiscal'
        ]);
        $model->addRule(['fiscal'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal = $current_fiscal->FISCAL;

        if ($_GET['fiscal'] != null) {
            $model->fiscal = $_GET['fiscal'];
        }

        if ($model->load($_GET)) {
            
        };

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal
        ])
        ->orderBy('PERIOD')
        ->all();
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_visit = KlinikInput::find()
        ->select([
            'dept', 'nik', 'nama',
            'total_minutes' => 'SUM(abs(timestampdiff(MINUTE, masuk, keluar)))',
            'total1' => 'COUNT(pk)'
        ])
        ->where([
            'EXTRACT(year_month FROM pk)' => $period_arr
        ])
        ->andWhere(['<>', 'opsi', 3])
        ->andWhere('keluar IS NOT NULL')
        ->groupBy('dept, nik, nama')
        ->orderBy('total_minutes DESC, nama')
        ->all();

        return $this->render('clinic-by-min', [
            'model' => $model,
            'data' => $tmp_visit
        ]);
    }

    public function actionToiletStatusData()
    {
        $data = [];
        $session = \Yii::$app->session;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = Toilet::find()->asArray()->all();

        foreach ($tmp_data as $key => $value) {
            $stopwatch = '';
            if ($value['room_value'] == 1) {
                $second_date = new \DateTime($value['end_date']);
                $first_date = new \DateTime($value['start_date']);
                $interval = $first_date->diff($second_date);
                $stopwatch = $interval->i . ':' . str_pad($interval->s, 2, '0', STR_PAD_LEFT);
            } else {
                
            }
            $data[] = [
                'room_id' => $value['room_id'],
                'room_desc' => $value['room_desc'],
                'room_value' => $value['room_value'],
                'stopwatch' => $stopwatch
            ];
        }

        return $data;
    }

    public function actionToiletStatus($value='')
    {
        $this->layout = 'clean';
        $data = Toilet::find()->asArray()->all();
        return $this->render('toilet-status', [
            'data' => $data
        ]);
    }

    public function actionDailyAttendanceDetail($proddate, $loc, $loc_desc)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $loc_desc . ' <small>(' . $proddate . ')<small></h3>
        </div>
        <div class="modal-body">
        ';

        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="">
            <th class="text-center">NO</th>
            <th class="text-center">NIK</th>
            <th class="">Name</th>
        </tr>';

        $no = 1;
        if($loc != 'WF01'){
            $tmp_att_data = ProdAttendanceData::find()
            ->select([
                'nik', 'name'
            ])
            ->where([
                'posting_shift' => $proddate,
                'child_analyst' => $loc,
                'current_status' => 'I'
            ])
            ->orderBy('name')
            ->all();

            
            foreach ($tmp_att_data as $key => $value) {
                $remark .= '<tr style="">
                    <td class="text-center">' . $no++ . '</td>
                    <td class="text-center">' . $value->nik . '</td>
                    <td class="">' . $value->name . '</td>
                </tr>';
            }
        } else {
            $fa_mp_arr = FaMp01::find()->where(['tgl' => $proddate])->orderBy('nama')->all();
            foreach ($fa_mp_arr as $key => $value) {
                $remark .= '<tr style="">
                    <td class="text-center">' . $no++ . '</td>
                    <td class="text-center">' . $value->nik . '</td>
                    <td class="">' . $value->nama . '</td>
                </tr>';
            }
        }

        return $remark;
    }

    public function actionDailyProdAttendance($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $posting_shift = date('Y-m-d');

        
        $model = new \yii\base\DynamicModel([
            'map_no', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','map_no'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

        if ($model->load($_GET)) {
            
        }

        $tmp_att_data = ProdAttendanceData::find()
        ->select([
            'child_analyst', 'child_analyst_desc', 'posting_shift',
            'total' => 'COUNT(nik)'
        ])
        ->where([
            'AND',
            ['>=', 'posting_shift', $model->from_date],
            ['<=', 'posting_shift', $model->to_date],
        ])
        ->groupBy('child_analyst, child_analyst_desc, posting_shift')
        ->orderBy('child_analyst_desc')
        ->all();

        $tmp_location = WipLocation::find()->where(['<>', 'child_analyst', 'WF01'])->orderBy('child_analyst_desc')->all();

        $tmp_data = $data = $categories = [];

        foreach ($tmp_location as $key => $location) {
            
            foreach ($tmp_att_data as $key => $value) {
                if ($value->child_analyst == $location->child_analyst) {
                    $proddate = (strtotime($value->posting_shift . " +7 hours") * 1000);
                    $tmp_data[$location->child_analyst_desc][] = [
                        'x' => $proddate,
                        'y' => (int)$value->total,
                        'url' => Url::to(['daily-attendance-detail', 'proddate' => $value->posting_shift, 'loc' => $value->child_analyst, 'loc_desc' => $value->child_analyst_desc]),
                    ];
                }
                
            }
        }

        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => $key,
                'data' => $value
            ];
        }
        
        $fa_mp_arr = FaMp02::find()
        ->where([
            'AND',
            ['>=', 'tgl', $model->from_date],
            ['<=', 'tgl', $model->to_date],
        ])
        ->orderBy('tgl')
        ->all();

        $tmp_fa = [];
        foreach ($fa_mp_arr as $key => $value) {
            $proddate = (strtotime($value->tgl . " +7 hours") * 1000);
            $tmp_fa[] = [
                'x' => $proddate,
                'y' => (int)$value->total_mp,
                'url' => Url::to(['daily-attendance-detail', 'proddate' => $value->tgl, 'loc' => 'WF01', 'loc_desc' => 'FINAL ASSY']),
            ];
        }

        $data[] = [
            'name' => 'FINAL ASSY',
            'data' => $tmp_fa
        ];
        /*$data[] = [
            'name' => 'Total Manpower',
            'data' => $tmp_data
        ];*/

        return $this->render('daily-prod-attendance', [
            'data' => $data,
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    public function actionTempHumidityChart()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $model = new \yii\base\DynamicModel([
            'map_no', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','map_no'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d')));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        $data = $tmp_data_temperature = $tmp_data_humidity = [];

        $model->map_no = $_GET['map_no'];

        if ($model->load($_GET)) {

        }

        $data_dummy = SensorLog::find()
        ->where([
            'AND',
            ['>=', 'system_date_time', date('Y-m-d H:i:s', strtotime($model->from_date . ' 00:00:01'))],
            ['<=', 'system_date_time', date('Y-m-d H:i:s', strtotime($model->to_date . ' 24:00:00'))]
        ])
        ->andWhere(['map_no' => $model->map_no])
        ->asArray()
        ->all();

        foreach ($data_dummy as $value) {
            $proddate = (strtotime($value['system_date_time'] . " +7 hours") * 1000);
            if ($value['temparature'] > 0) {
                $tmp_data_temperature[] = [
                    'x' => $proddate,
                    'y' => (int)$value['temparature']
                ];
            }
            if ($value['humidity'] > 0) {
                $tmp_data_humidity[] = [
                    'x' => $proddate,
                    'y' => (int)$value['humidity']
                ];
            }
            
        }

        $data = [
            'temparature' => [
                [
                    'name' => 'Temperature',
                    'data' => $tmp_data_temperature,
                    'color' => new JsExpression('Highcharts.getOptions().colors[1]')
                    //'color' => 'white'
                ],
            ],
            'humidity' => [
                [
                    'name' => 'Humidity',
                    'data' => $tmp_data_humidity,
                    'color' => new JsExpression('Highcharts.getOptions().colors[1]')
                    //'color' => 'white'
                ],
            ],
        ];

        $sensor_data = SensorTbl::find()
        ->where([
            'map_no' => $model->map_no
        ])
        ->one();

        return $this->render('temp-humidity-chart', [
            'data' => $data,
            'model' => $model,
            'sensor_data' => $sensor_data,
        ]);
    }

    public function ationTempHumiData($value='')
    {
        # code...
    }

    public function actionTempHumidityControl($category)
    {
        $this->layout = 'clean';

        if ($category == 1) {
            $title = [
                //'page_title' => 'Temperature Monitoring <small style="color: white; opacity: 0.8;" id="last-update"> Last Update : ' . date('Y-m-d H:i:s') . '</small><span class="japanesse text-green"></span>',
                'page_title' => null,
                'tab_title' => 'Temperature Monitoring',
                'breadcrumbs_title' => 'Temperature Monitoring'
            ];
            $custom_title = 'Temperature<br/>Monitoring';
        } elseif ($category == 2) {
            $title = [
                //'page_title' => 'Humidity Monitoring <small style="color: white; opacity: 0.8;" id="last-update"> Last Update : ' . date('Y-m-d H:i:s') . '</small><span class="japanesse text-green"></span>',
                'page_title' => null,
                'tab_title' => 'Humidity Monitoring',
                'breadcrumbs_title' => 'Humidity Monitoring'
            ];
            $custom_title = 'Humidity<br/>Monitoring';
        }
        
        $data = SensorTbl::find()->where([
            'is_showing' => 1
        ])->all();

        return $this->render('temp-humidity-control', [
            'data' => $data,
            'title' => $title,
            'category' => $category,
            'custom_title' => $custom_title,
        ]);
    }

    public function actionLotFlowProcess($lot_number)
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = $tmp_data = $categories = [];
        $now = date('Y-m-d H:i:s');

        $machine_output_arr = MachineIotOutput::find()
        ->where([
            'lot_number' => $lot_number
        ])
        ->andWhere('start_date IS NOT NULL')
        ->orderBy('start_date')
        ->all();

        $index = 0;
        $part_name = '';
        foreach ($machine_output_arr as $machine_output) {
            if ($part_name == '') {
                $part_name = $machine_output->gmc . ' - ' . $machine_output->gmc_desc . ' (' . $machine_output->lot_qty . ' PCS)';
            }
            $categories[] = $machine_output->mesin_id . ' - ' . $machine_output->mesin_description;
            $start_date = $machine_output->start_date;
            $start_date_js = strtotime($start_date . " +7 hours") * 1000;
            if ($machine_output->end_date == null) {
                $end_date = $now;
            } else {
                $end_date = $machine_output->end_date;
            }
            $end_date_js = strtotime($end_date . " +7 hours") * 1000;
            $tmp_data[] = [
                'x' => $start_date_js,
                'x2' => $end_date_js,
                'y' => $index,
                'color' => \Yii::$app->params['bg-green']
            ];
            $index++;
        }

        $data = [
            [
                'name' => 'Lot Timeline',
                'data' => $tmp_data,
                'showInLegend' => false,
                'pointWidth' => 20,
            ]
        ];

        return $this->render('lot-flow-process', [
            'data' => $data,
            'lot_number' => $lot_number,
            'part_name' => $part_name,
            'categories' => $categories,
        ]);
    }
    public function actionGosubLocationData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $data = $tmp_data = $absolute_loc_arr = [];
        $location_arr = [
            'PANGKALAN' => [
                'top' => '775',
                'left' => '810',
                'max_left' => '980',
                'max_top' => '1225'
            ],
            'SUB-ASSY-NETWORK' => [
                'top' => '777',
                'left' => '545',
                'max_left' => '725',
                'max_top' => '1225'
            ],
            'SUB-ASSY-FRONT-GRILL' => [
                'top' => '142',
                'left' => '93',
                'max_left' => '470',
                'max_top' => '360'
            ],
            'SUB-ASSY-ACCESORIES' => [
                'top' => '142',
                'left' => '810',
                'max_left' => '1170',
                'max_top' => '360'
            ]
        ];
        $default_initial_location = [
            [
                'top' => '1135px',
                'left' => '1135px',
            ],
            [
                'top' => '1135px',
                'left' => '1135px',
            ],
            [
                'top' => '2275px',
                'left' => '165px',
                'max_left' => '675px',
                'max_top' => '360px'
            ],
            [
                'top' => '275px',
                'left' => '1135px',
                'max_left' => '1355px',
                'max_top' => '360px'
            ],
        ];
        //$now = '2019-08-14 09:25:00';
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_str = '';
        $tmp_str .= '<div class="row">';
        $tmp_str .= '</div>';

        $tmp_operator = GojekTbl::find()
        ->where([
            'SOURCE' => 'SUB',
            'HADIR' => 'Y'
        ])
        ->orderBy('GOJEK_DESC')
        ->all();

        foreach ($location_arr as $location => $location_detail) {
            $tmp_content = '<ol>';
            $count = 0;
            $top = $location_detail['top'];
            $left = $location_detail['left'];
            foreach ($tmp_operator as $key => $value) {
                if ($value->beacon_location == $location) {
                    $gosa_tbl = GojekOrderTbl::find()->where([
                        'GOJEK_ID' => $value->GOJEK_ID,
                        'post_date' => date('Y-m-d')
                    ])
                    ->orderBy('daparture_date DESC')
                    ->one();
                    $count++;
                    $seconds = $seconds_ori = 0;
                    if ($gosa_tbl->daparture_date !== null) {
                        $seconds = $seconds_ori = $this->getSeconds($gosa_tbl->daparture_date, $now);
                    }
                    
                    $seconds_str = ' seconds';
                    if ($seconds == 1) {
                        $seconds_str = ' second';
                    }
                    if ($seconds >= 60) {
                        $seconds = $this->getMinutes($gosa_tbl->daparture_date, $now);
                        $seconds_str = ' minutes';
                        if ($seconds == 1) {
                            $seconds_str = ' minute';
                        }
                        
                    }
                    if ($seconds >= 60) {
                        $seconds = round($seconds / 60, 1);
                        $seconds_str = ' hour';
                        if ($seconds > 1) {
                            $seconds_str = ' hours';
                        }
                    }
                    /*$top = ($value->position_y * 16.98);
                    if ($top < 0) {
                        $top = 0;
                    }
                    $left = ($value->position_x * 16.51);
                    if ($left < 0) {
                        $left = 0;
                    }*/
                    //if ($seconds_ori < 3600) {
                        $absolute_loc_arr[] = [
                            'station' => $location,
                            'nik' => $value->GOJEK_ID,
                            'name' => $value->GOJEK_DESC,
                            'last_update' => $seconds . $seconds_str,
                            'top' => $top . 'px',
                            'left' => $left . 'px',
                            'minor' => $value->minor,
                            'pos_x' => round($value->position_x, 3),
                            'pos_y' => round($value->position_y, 3),
                        ];
                        /**///$top += 25;
                        $left += 30;
                        if ($left > $location_detail['max_left']) {
                            $left = $location_detail['left'];
                            $top += 25;
                        }
                        $tmp_content .= '<li><span style="opacity: 0.9; letter-spacing: 1px;">' . $value->GOJEK_DESC . ' [' . round($value->distance, 1) . 'm] - </span><small style="opacity: 0.6;">' . $seconds . $seconds_str . ' working</small></li>';
                    //}
                }
            }
            $tmp_content .= '</ol>';
            if ($count == 0) {
                $tmp_content = '<span>No Operator Here ...</span>';
            }
            $tmp_data[strtolower($location)] = $tmp_content;
        }

        $data = [
            'data' => $tmp_data,
            'last_update' => '<u>Last Update : ' . date('Y-m-d H:i') . '</u>',
            'absolute_loc_arr' => $absolute_loc_arr
        ];
        return $data;
    }
    public function actionGosubLocation()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = $tmp_data = [];
        $location_arr = ['PANGKALAN', 'SUB-ASSY-NETWORK', 'SUB-ASSY-FRONT-GRILL', 'SUB-ASSY-ACCESORIES'];

        return $this->render('gosub-location', [
            'data' => $data,
            'location_arr' => $location_arr,
        ]);
    }
    public function actionGosubTimeline($terminal = 'NETWORK ASSY')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = $tmp_data = $categories = [];
        $posting_date = date('Y-m-d');

        $model = new \yii\base\DynamicModel([
            'posting_date', 'operator'
        ]);
        $model->addRule(['posting_date','operator'], 'required');
        $model->posting_date = $posting_date;
        

        if ($model->load($_GET)) {
            
        }
        $today_name = date('D', strtotime($model->posting_date));

        $max_x = (strtotime($model->posting_date . ' 24:00:00' . " +7 hours") * 1000);
        $min_x = (strtotime($model->posting_date . ' 00:00:00' . " +7 hours") * 1000);
        $tmp_operator = GojekTbl::find()
        ->where([
            'SOURCE' => 'SUB',
            'TERMINAL' => $terminal
        ])
        ->andWhere(['<>', 'HADIR', 'M'])
        ->all();

        $tmp_order = GojekOrderTbl::find()
        ->where([
            'source' => 'SUB',
            'post_date' => $model->posting_date
        ])
        ->andWhere('daparture_date IS NOT NULL')
        ->orderBy('GOJEK_ID, daparture_date')
        ->all();

        $index = 0;
        $idle_s = 0;
        $tmp_start_end = [];
        foreach ($tmp_operator as $operator) {
            $categories[] = $operator->nikName;
            foreach ($tmp_order as $order) {
                if ($operator->GOJEK_ID == $order->GOJEK_ID) {

                    $start_time_ori = $order->daparture_date;

                    $start_time = (strtotime($order->daparture_date . " +7 hours") * 1000);
                    if ($order->STAT == 'C') {
                        $end_time = (strtotime($order->arrival_date . " +7 hours") * 1000);
                        $end_time_ori = $order->arrival_date;
                    } else {
                        $end_time = (strtotime(date('Y-m-d H:i:s') . " +7 hours") * 1000);
                        $end_time_ori = date('Y-m-d H:i:s');
                    }

                    $tmp_start_end[$operator->GOJEK_ID][] = [
                        'start' => $start_time_ori,
                        'end' => $end_time_ori
                    ];

                    $break_time1 = $model->posting_date . ' 09:20:00';
                    $break_time1_end = $model->posting_date . ' 09:30:00';
                    $break_time2 = $model->posting_date . ' 12:10:00';
                    $break_time2_end = $model->posting_date . ' 12:50:00';
                    $break_time3 = $model->posting_date . ' 14:20:00';
                    $break_time3_end = $model->posting_date . ' 14:30:00';

                    if ($today_name == 'Fri') {
                        $break_time2 = $model->posting_date . ' 12:00:00';
                        $break_time2_end = $model->posting_date . ' 13:10:00';
                        $break_time3 = $model->posting_date . ' 14:50:00';
                        $break_time3_end = $model->posting_date . ' 15:00:00';
                    }

                    if (strtotime($start_time_ori) < strtotime($break_time1) && strtotime($end_time_ori) > strtotime($break_time1)) {
                        $start_time = (strtotime($start_time_ori . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time1 . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-green']
                        ];

                        $start_time = (strtotime($break_time1 . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time1_end . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-yellow']
                        ];

                        if (strtotime($end_time_ori) > strtotime($break_time1_end)) {
                            $start_time_ori = $break_time1_end;
                        }
                        
                    }

                    if (strtotime($start_time_ori) < strtotime($break_time2) && strtotime($end_time_ori) > strtotime($break_time2)) {
                        $start_time = (strtotime($start_time_ori . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time2 . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-green']
                        ];

                        $start_time = (strtotime($break_time2 . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time2_end . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-yellow']
                        ];
                        
                        if (strtotime($end_time_ori) > strtotime($break_time2_end)) {
                            $start_time_ori = $break_time2_end;
                        }
                        
                    }

                    if (strtotime($start_time_ori) < strtotime($break_time3) && strtotime($end_time_ori) > strtotime($break_time3)) {
                        $start_time = (strtotime($start_time_ori . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time3 . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-green']
                        ];

                        $start_time = (strtotime($break_time3 . " +7 hours") * 1000);
                        $tmp_data[] = [
                            'x' => $start_time,
                            'x2' => (strtotime($break_time3_end . " +7 hours") * 1000),
                            'y' => $index,
                            'color' => \Yii::$app->params['bg-yellow']
                        ];

                        if (strtotime($end_time_ori) > strtotime($break_time3_end)) {
                            $start_time_ori = $break_time3_end;
                        }
                        
                    }

                    $start_time = (strtotime($start_time_ori . " +7 hours") * 1000);
                    $tmp_data[] = [
                        'x' => $start_time,
                        'x2' => (strtotime($end_time_ori . " +7 hours") * 1000),
                        'y' => $index,
                        'color' => \Yii::$app->params['bg-green']
                    ];
                }
            }
            $index++;
        }

        $tmp_idle_time = [];
        $tmp_end_time = null;
        $total_idling_time = 0;
        foreach ($tmp_start_end as $nik => $operator_start_end) {
            foreach ($operator_start_end as $key => $value) {
                if ($key > 0) {
                    $diff_seconds = strtotime($value['start']) - strtotime($operator_start_end[$key - 1]['end']);
                    if ($diff_seconds > 0) {
                        $tmp_idle_time[$nik] += $diff_seconds;
                        $total_idling_time += $diff_seconds;
                    }
                    
                }
            }
        }

        $data = [
            [
                'name' => 'Operator Timeline',
                'data' => $tmp_data,
                'showInLegend' => false,
                'pointWidth' => 20,

            ]
        ];

        return $this->render('gosub-timeline', [
            'data' => $data,
            'min_x' => $min_x,
            'max_x' => $max_x,
            'categories' => $categories,
            'model' => $model,
            'tmp_idle_time' => $tmp_idle_time,
            'total_idling_time' => $total_idling_time,
            'tmp_start_end' => $tmp_start_end
        ]);
    }
    public function actionTodaysMeetingData($room_id)
    {
        //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');
        $today = date('Y-m-d');
        if ($room_id == 9) {
            $meeting_content = '<span style="font-size: 10em; color: rgba(255, 235, 59, 1)">NO GUEST TODAY</span>';
        } elseif ($room_id == 13){
            $meeting_content = '<span style="font-size: 10em; color: rgba(255, 235, 59, 1)">NO PATROL TODAY</span>';
        } else {
            $meeting_content = '<span style="font-size: 10em; color: rgba(255, 235, 59, 1)">NO MEETING TODAY</span>';
        }
        $room_info = MrbsRoom::find()
        ->where(['id' => (int)$room_id])
        ->one();

        $room_name = strtoupper($room_info->room_name);
        if ($room_id == 1 || $room_id == 6) {
            $room_name = strtoupper($room_info->room_name . ' ROOM');
        }

        $tmp_data = MeetingEvent::find()
        ->where([
            'room_id' => $room_id,
        ])
        ->andWhere([
            'AND',
            ['<=', 'tgl_start', $today],
            ['>=', 'tgl_end', $today]
        ])
        ->orderBy('jam_start')
        ->all();

        if (count($tmp_data) > 0) {
            $meeting_content = '<table class="table" cellspacing="0" style="">';
            $count = 1;
            foreach ($tmp_data as $key => $value) {
                if ($value->jam_end < date('H:i:s')) {
                    $font_color = 'rgba(255, 235, 59, 0.3)';
                    $opacity = 0.3;
                } else {
                    $font_color = 'rgba(255, 235, 59, 1)';
                    $opacity = 0.9;
                }

                $background_color = 'rgba(255, 255, 255, 0)';
                if (date('H:i:s') > $value->jam_start && date('H:i:s') < $value->jam_end) {
                    $background_color = 'rgba(255, 255, 255, 0.25)';
                }
                if ($room_id == 9) {
                    $splitted_name = explode(',', $value->name);
                    $new_list = '';
                    if (count($splitted_name) < 5) {
                        foreach ($splitted_name as $key => $japanesse_name) {
                            $new_list .= '<div class="col-md-12">» ' . $japanesse_name . '</div>';
                        }
                        $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); background-color: rgba(255, 255, 255, 0);">
                        <td style="border-top: 0px; font-size: 7em; font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif">' . $new_list . '</td></tr>';
                    } else {
                        foreach ($splitted_name as $key => $japanesse_name) {
                            $new_list .= '<div class="col-md-6">» ' . $japanesse_name . '</div>';
                        }
                        $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); background-color: rgba(255, 255, 255, 0);">
                        <td style="border-top: 0px; font-size: 3.5em; font-family: \'Source Sans Pro\',\'Helvetica Neue\',Helvetica,Arial,sans-serif">' . $new_list . '</td></tr>';
                    }
                    
                } elseif ($room_id == 13) {
                    $splitted_name = explode('<br/>', $value->name);
                    if (count($splitted_name) > 7) {
                        $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); opacity: ' . $opacity . '; background-color: ' . $background_color . ';">
                        <td style="border-top: 0px; width: 540px; color: rgba(59, 255, 248, 1); font-size: 5.5em; padding: 6px 0px 0px 20px;">(' . substr($value->jam_start, 0, 5) . '-' . substr($value->jam_end, 0, 5) .
                        ')</td>
                        <td style="border-top: 0px; font-size: 5.5em;">' . $value->name . '</td></tr>';
                    } else {
                        $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); opacity: ' . $opacity . '; background-color: ' . $background_color . ';">
                        <td style="border-top: 0px; width: 540px; color: rgba(59, 255, 248, 1); font-size: 5.5em; padding: 6px 0px 0px 20px;">(' . substr($value->jam_start, 0, 5) . '-' . substr($value->jam_end, 0, 5) .
                        ')</td>
                        <td style="border-top: 0px; font-size: 6em;">' . $value->name . '</td></tr>';
                    }
                } else {
                    $meeting_content .= '<tr style="color: rgba(255, 235, 59, 1); opacity: ' . $opacity . '; background-color: ' . $background_color . ';">
                    <td style="border-top: 0px; width: 540px; color: rgba(59, 255, 248, 1); font-size: 5.5em; padding: 6px 0px 0px 20px;">(' . substr($value->jam_start, 0, 5) . '-' . substr($value->jam_end, 0, 5) .
                    ')</td>
                    <td style="border-top: 0px; font-size: 6em;">' . $value->name . '</td></tr>';
                }
                
            }
            $meeting_content .= '</table>';
        }
        
        $data = [
            'room_name' => $room_name,
            'today' => strtoupper(date('d M\' Y')) . ' <small style="color: #D58936;"><b>' . date('H:i') . '</b></small>',
            'meeting_content' => $meeting_content
        ];
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    public function actionTodaysMeeting()
    {
        $this->layout = 'clean';
        $today = date('Y-m-d');
        $data = [];
        $room_name = '';

        if (isset($_GET['room_id']) && $_GET['room_id'] != null) {
            $room_info = MrbsRoom::find()
            ->where(['id' => (int)$_GET['room_id']])
            ->one();

            $tmp_data = MeetingEvent::find()
            ->where([
                'room_id' => $_GET['room_id'],
                'tgl_start' => $today
            ])
            ->all();
            //echo $_GET['room_id'];
        }
        
        return $this->render('todays-meeting', [
            'data' => $tmp_data,
            'room_info' => $room_info,
        ]);
    }

    public function actionChourei()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        //$yesterday = date('Y-m-d', strtotime('-1 day'));
        $today = date('Y-m-d');
        //$tomorrow = date('Y-m-d', strtotime('+1 day'));

        $tmp_yesterday = SernoCalendar::find()
        ->select('etd')
        ->where(['<', 'etd', $today])
        ->orderBy('etd DESC')
        ->one();
        //echo $tmp_yesterday->etd;

        $serno_calendar = SernoCalendar::find()
        ->select('etd')
        ->where(['>=', 'etd', $tmp_yesterday->etd])
        ->limit(3)
        ->all();

        $cal_arr = [];
        foreach ($serno_calendar as $key => $value) {
            $cal_arr[] = $value->etd;
        }

        $shipping_data = SernoOutput::find()
        ->joinWith('sernoMaster')
        ->select([
            'etd',
            'model' => 'tb_serno_master.model',
            'qty' => 'SUM(qty)',
            'output' => 'SUM(output)',
            'balance' => 'SUM(output-qty)'
        ])
        ->where(['etd' => $cal_arr])
        ->groupBy('etd, tb_serno_master.model')
        ->orderBy('etd')
        ->all();

        $tmp_shipping_arr = [];
        $model_name = [];
        foreach ($shipping_data as $key => $value) {
            $tmp_shipping_arr[$value->etd]['plan'] += $value->qty;
            $tmp_shipping_arr[$value->etd]['actual'] += $value->output;
            $tmp_shipping_arr[$value->etd]['balance'] += $value->balance;

            if ($value->balance < 0) {
                if (!isset($tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model])) {
                    $gmc_desc = $value->sernoMaster->description;
                    $tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model] = 0;
                    $model_name[$value->model] = $gmc_desc;
                }
                $tmp_shipping_arr[$value->etd]['gmc_balance'][$value->model] += $value->balance;
            }

            //arsort($tmp_shipping_arr[$value->etd]['gmc_balance']);
        }

        foreach ($cal_arr as $key => $value) {
            $plan = $tmp_shipping_arr[$value]['plan'];
            $actual = $tmp_shipping_arr[$value]['actual'];
            if ($plan > 0) {
                $pct = round(($actual / $plan) * 100, 1);
            } else {
                $pct = 0;
            }
            $tmp_shipping_arr[$value]['percentage'] = $pct;

            if (isset($tmp_shipping_arr[$value]['gmc_balance'])) {
                asort($tmp_shipping_arr[$value]['gmc_balance']);
                $tmp_shipping_arr[$value]['gmc_balance'] = array_slice($tmp_shipping_arr[$value]['gmc_balance'], 0, 3);
            }

        }

        //vms
        $wip_hdr_dtr = WipHdrDtr::find()
        ->select([
            'source_date', 'child_analyst', 'child_analyst_desc', 'model_group',
            'plan_total' => 'SUM(act_qty)',
            'output_total' => 'SUM(CASE WHEN stage IN (\'03-COMPLETED\', \'04-HAND OVER\') THEN act_qty ELSE 0 END)',
            'balance_total' => 'SUM(CASE WHEN stage IN (\'00-ORDER\', \'01-CREATED\', \'02-STARTED\') THEN -act_qty ELSE 0 END)'
        ])
        ->where([
            'source_date' => $cal_arr,
            'child_analyst' => ['WP01', 'WW02']
        ])
        ->andWhere('stage IS NOT NULL')
        ->groupBy('source_date, child_analyst, child_analyst_desc, model_group')
        ->orderBy('source_date, child_analyst_desc, balance_total')
        ->asArray()
        ->all();

        $tmp_vms_data = [];
        foreach ($wip_hdr_dtr as $key => $value) {
            $source_date = date('Y-m-d', strtotime($value['source_date']));
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['plan'] += $value[plan_total];
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['actual'] += $value[output_total];
            $tmp_vms_data[$value['child_analyst_desc']][$source_date]['balance'] += $value[balance_total];

            if ($value['balance_total'] < 0) {
                $tmp_vms_data[$value['child_analyst_desc']][$source_date]['gmc_balance'][$value['model_group']] = $value['balance_total'];
            }
        }

        foreach ($tmp_vms_data as $child_analyst_desc => $summary_arr) {
            foreach ($summary_arr as $source_date => $value) {
                $tmp_pct = 0;
                $plan = $value['plan'];
                $actual = $value['actual'];
                if ($plan > 0) {
                    $tmp_pct = round(($actual / $plan) * 100, 2);
                }
                $tmp_vms_data[$child_analyst_desc][$source_date]['percentage'] = $tmp_pct;

                if (isset($tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'])) {
                    $tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'] = array_slice($tmp_vms_data[$child_analyst_desc][$source_date]['gmc_balance'], 0, 3);
                }
            }
        }

        return $this->render('chourei', [
            'shipping_data' => $tmp_shipping_arr,
            'cal_arr' => $cal_arr,
            'vms_data' => $tmp_vms_data,
        ]);
    }

    public function getMinutes($start, $end)
    {
        $start_date = new \DateTime($start);
        $since_start = $start_date->diff(new \DateTime($end));
        $minutes = $since_start->days * 24 * 60;
        $minutes += $since_start->h * 60;
        $minutes += $since_start->i;
        return $minutes;
    }

    public function getSeconds($start, $end)
    {
        $start_date = new \DateTime($start);
        $since_start = $start_date->diff(new \DateTime($end));
        $seconds = $since_start->days * 24 * 3600;
        $seconds += $since_start->h * 3600;
        $seconds += $since_start->i * 60;
        $seconds += $since_start->s;
        return $seconds;
    }

    public function actionGoSubDriverUtility()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $data = $categories = $tmp_data = $tmp_data2 = [];
        $post_date = date('Y-m-d');

        $tmp_driver = GojekTbl::find()
        ->select(['GOJEK_ID', 'GOJEK_DESC'])
        ->where([
            'SOURCE' => 'SUB',
            'HADIR' => 'Y'
        ])
        ->orderBy('GOJEK_DESC')
        ->all();

        $tmp_order = GojekOrderTbl::find()
        ->where([
            'source' => 'SUB',
            'FORMAT(post_date, \'yyyy-MM-dd\')' => $post_date
        ])
        ->andWhere('daparture_date IS NOT NULL')
        ->all();

        foreach ($tmp_driver as $driver) {
            $lt = 0;
            foreach ($tmp_order as $value) {
                if ($value->GOJEK_ID == $driver->GOJEK_ID) {
                    if ($value->LT != null) {
                        $lt += $value->LT;
                    } else {
                        $lt += GeneralFunction::instance()->getWorkingTime($value->daparture_date, date('Y-m-d H:i:s'));
                    }
                    
                }
            }
            $tmp_data[$driver->GOJEK_ID . ' - ' . $driver->GOJEK_DESC] = $lt;
        }

        arsort($tmp_data);
        foreach ($tmp_data as $key => $value) {
            $categories[] = $key;
            $utility = 0;
            if ($value > 0) {
                $utility = round(($value / 470) * 100, 1);
            }
            $tmp_data2[] = [
                'y' => $utility,
                'color' => 'red'
            ];
        }

        $data[] = [
            'name' => 'Driver Utility',
            'data' => $tmp_data2,
            'showInLegend' => false
        ];
        
        return $this->render('go-sub-driver-utility', [
            'data' => $data,
            'categories' => $categories,
            'tmp_data' => $tmp_data,
        ]);
    }

    public function isBreakTime($datetime)
    {
        date_default_timezone_set('Asia/Jakarta');
        $today_name = date('D');

        $datetime = new \DateTime($datetime);

        $break_time1 = new \DateTime(date('Y-m-d 09:20:00'));
        $break_time1_end = new \DateTime(date('Y-m-d 09:30:00'));
        $break_time2 = new \DateTime(date('Y-m-d 12:10:00'));
        $break_time2_end = new \DateTime(date('Y-m-d 12:50:00'));
        $break_time3 = new \DateTime(date('Y-m-d 14:20:00'));
        $break_time3_end = new \DateTime(date('Y-m-d 14:30:00'));

        if ($today_name == 'Fri') {
            $break_time2 = new \DateTime(date('Y-m-d 12:00:00'));
            $break_time2_end = new \DateTime(date('Y-m-d 13:10:00'));
            $break_time3 = new \DateTime(date('Y-m-d 14:50:00'));
            $break_time3_end = new \DateTime(date('Y-m-d 15:00:00'));
        }

        if ($datetime > $break_time1 && $datetime < $break_time1_end) {
            return true;
        }

        if ($datetime > $break_time2 && $datetime < $break_time2_end) {
            return true;
        }

        if ($datetime > $break_time3 && $datetime < $break_time3_end) {
            return true;
        }

        return false;
    }

    public function actionGoSubDriverStatusData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        //$now = '2019-08-14 09:25:00';
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $tmp_data = GojekTbl::find()
        ->where(['SOURCE' => 'SUB'])
        ->andWhere(['<>', 'HADIR', 'M'])
        ->orderBy('GOJEK_DESC')->all();
        $tmp_order = GojekOrderTbl::find()
        ->where([
            'source' => 'SUB',
            'STAT' => 'O'
        ])
        //->andWhere('daparture_date IS NULL')
        ->asArray()
        ->all();
        $tmp_str = '';
        $tmp_str .= '<div class="row">';
        foreach ($tmp_data as $key => $value) {
            $data_karyawan = $value->karyawan;
            $is_end_contract = 0;
            $d1 = new \DateTime($now);
            if ($data_karyawan->KONTRAK_KE == 1) {
                $d2 = new \DateTime($data_karyawan->K1_END);
                if ($d1 > $d2) {
                    $is_end_contract = 1;
                }
            } else {
                $d2 = new \DateTime($data_karyawan->K2_END);
                if ($d1 > $d2) {
                    $is_end_contract = 1;
                }
            }
            if ($is_end_contract == 0) {
                $get_new_order = false;
                $txt_new_order = '';
                $current_job = 'No Job Order';
                foreach ($tmp_order as $key => $value_order) {
                    if ($value_order['GOJEK_ID'] == $value->GOJEK_ID) {
                        if ($value_order['daparture_date'] == NULL) {
                            $get_new_order = true;
                        }
                        $current_job = $value_order['item_desc'];
                    }
                }
                $current_job .= ' | ' . $is_end_contract;

                if ($value->HADIR == 'N') {
                    $bg_class = ' bg-gray';
                    $text_remark = 'INACTIVE';
                } else {
                    if ($value->STAGE == 'STANDBY') {
                        $bg_class = ' bg-red';
                        $text_remark = 'STANDBY';
                    } elseif ($value->STAGE == 'DEPARTURE') {
                        $bg_class = ' bg-green';
                        $text_remark = 'START WORKING - ' . date('H:i', strtotime($value->LAST_UPDATE)) . '';
                    } elseif ($value->STAGE == 'ARRIVAL') {
                        $bg_class = ' bg-yellow';
                        $text_remark = 'JUST FINISHED - ' . date('H:i', strtotime($value->LAST_UPDATE)) . '';
                        $diff_min = $this->getMinutes($value->LAST_UPDATE, date('Y-m-d H:i:s'));
                        if ($diff_min > 7) {
                            if ($value->LAST_UPDATE == date('Y-m-d')) {
                            	if ($diff_min > 60) {
		                        	$bg_class = ' bg-light-blue';
                                	$text_remark = 'STANDBY';
		                        } else {
		                        	$bg_class = ' bg-light-blue';
                                	$text_remark = 'IDLING > 2 MIN [ SINCE - ' . date('H:i', strtotime($value->LAST_UPDATE)) . ' ]';
		                        }
                                
                            } else {
                                $bg_class = ' bg-light-blue';
                                $text_remark = 'STANDBY';
                                if ($now > date('Y-m-d 16:00:00')) {
                                    $bg_class = ' bg-gray';
                                    $text_remark = 'INACTIVE';
                                }
                            }
                            if ($get_new_order) {
                                $txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">New Order!</span>';
                            }
                        }


                    } else {
                        $bg_class = ' bg-aqua';
                        $text_remark = 'NO INFORMATION';
                    }
                    if ($this->isBreakTime($now)) {
                        $txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">Break Time!</span>';
                    }
                    //$txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">Break Time!</span>';
                    //$txt_new_order = '<span class="pull-right label label-default" style="position: absolute; top: 65px; right: 10px;">New Order!</span>';
                }
                
                $filename = $value->GOJEK_ID . '.jpg';
                $path = \Yii::$app->basePath . '\\web\\uploads\\yemi_employee_img\\' . $filename;
                if (file_exists($path)) {
                    $profpic =  Html::img('@web/uploads/yemi_employee_img/' . $value->GOJEK_ID . '.jpg', [
                        'class' => 'img-circle',
                        'style' => 'object-fit: cover; height: 60px; width: 60px;'
                    ]);
                } else {
                    $profpic =  Html::img('@web/uploads/profpic_03.png', [
                        'class' => 'img-circle',
                        'style' => 'object-fit: cover; height: 60px; width: 60px;'
                    ]);
                }
                
                $tmp_str .= '<div class="col-md-3">
                    <div class="box box-widget widget-user-2' . $bg_class . '">
                        <div class="widget-user-header">
                            <div class="widget-user-image">
                                ' . $profpic . '
                            </div>
                            <h3 class="widget-user-username" style="font-size: 18px; font-weight: 500;">' . $value->GOJEK_DESC . ' <span style="position: absolute; top: 10px; right: 10px;">[' . $value->GOJEK_ID . ']</span>' . $txt_new_order . '</h3>
                            <h5 class="widget-user-desc">' . $text_remark . '</h5>
                        </div>
                        <div class="text-left" style="background: rgba(0,0,0,0.15); padding: 2px 5px;">
                            <span style="opacity: 0.8;">JOB : ' . strtoupper($current_job) . '</span>
                        </div>
                        
                    </div>
                </div>';
            }
            
        }
        $tmp_str .= '</div>';
        $data = [
            'content' => $tmp_str,
            'last_update' => '<u>Last Update : ' . date('Y-m-d H:i') . '</u>'
        ];
        return $data;
    }
    public function actionGoSubDriverStatus($value='')
    {
        $this->layout = 'clean';
        $data = [];
        return $this->render('go-sub-driver-status', [
            'data' => $data
        ]);
    }

    public function actionFgsStockDetail($over_category, $days, $category)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>FGS Stock <small>(' . $category . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th>Port</th>
            <th class="text-center">GMC</th>
            <th>Description</th>
            <th class="text-center">Qty</th>
        </tr>';

        if ($over_category == 1) {
            $data_arr = SernoInput::find()
            ->joinWith('sernoOutput')
            ->joinWith('sernoMaster')
            ->select([
                'tb_serno_output.dst', 'tb_serno_input.gmc',
                'tb_serno_master.model', 'tb_serno_master.dest', 'tb_serno_master.color',
                'total' => 'COUNT(tb_serno_input.gmc)'
            ])
            ->where([
                'loct' => 2,
                'tb_serno_input.adv' => 0,
            ])
            ->andWhere(['<>', 'loct_time', '0000-00-00'])
            ->andWhere(['>=', 'DATEDIFF(tb_serno_output.etd, CURDATE())', $days])
            ->groupBy('tb_serno_output.dst, tb_serno_input.gmc')
            ->all();
        } else {
            $data_arr = SernoInput::find()
            ->joinWith('sernoOutput')
            ->joinWith('sernoMaster')
            ->select([
                'tb_serno_output.dst', 'tb_serno_input.gmc',
                'tb_serno_master.model', 'tb_serno_master.dest', 'tb_serno_master.color',
                'total' => 'COUNT(tb_serno_input.gmc)'
            ])
            ->where([
                'loct' => 2,
                'tb_serno_input.adv' => 0,
                'DATEDIFF(tb_serno_output.etd, CURDATE())' => $days
            ])
            ->andWhere(['<>', 'loct_time', '0000-00-00'])
            ->groupBy('tb_serno_output.dst, tb_serno_input.gmc')
            ->all();
        }
        

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 14px;">
                <td>' . $value->dst . '</td>
                <td class="text-center">' . $value->gmc . '</td>
                <td>' . $value->partName . '</td>
                <td class="text-center">' . $value->total . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionFgsStock($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $limit_over = 12;

        $tmp_input_arr = SernoInput::find()
        ->joinWith('sernoOutput')
        ->select([
            'days_diff' => 'DATEDIFF(tb_serno_output.etd, CURDATE())',
            'dst' => 'tb_serno_output.dst',
            'total' => 'COUNT(CURDATE())'
        ])
        ->where([
            'loct' => 2,
            'tb_serno_input.adv' => 0
        ])
        ->andWhere(['<>', 'loct_time', '0000-00-00'])
        ->groupBy('DATEDIFF(tb_serno_output.etd, CURDATE()), tb_serno_output.dst')
        ->having('days_diff > -1')
        ->orderBy('DATEDIFF(tb_serno_output.etd, CURDATE()) DESC, tb_serno_output.dst')
        ->all();

        $tmp_data = $tmp_data2 = $tmp_data3 = $categories = [];
        foreach ($tmp_input_arr as $key => $value) {
            $tmp_title = $limit_over;

            if ($value->days_diff < $limit_over) {
                $tmp_title = $value->days_diff;
            }

            if (!isset($tmp_data[$tmp_title])) {
                $tmp_data[$tmp_title] = 0;
            }
            $tmp_data[$tmp_title] += $value->total;

            if (!isset($tmp_data3[$tmp_title][$value->dst])) {
                $tmp_data3[$tmp_title][$value->dst] = 0;
            }
            $tmp_data3[$tmp_title][$value->dst] += $value->total;
        }

        foreach ($tmp_data as $key => $value) {
            $tmp_category = '';
            if ((int)$key == $limit_over) {
                $tmp_category = $key . ' d and over';
                $over_category = 1;
            } elseif((int)$key == 0) {
                $tmp_category = 'Today';
                $over_category = 0;
            } else {
                $tmp_category = $key . ' d';
                $over_category = 0;
            }

            $categories[] = $tmp_category;
            
            $tmp_data2[] = [
                'y' => $value,
                'url' => Url::to(['fgs-stock-detail', 'over_category' => $over_category, 'days' => (int)$key, 'category' => $tmp_category]),
            ];
        }

        $data_table = $table_column = [];
        foreach ($tmp_data3 as $key => $value) {
            arsort($value);
            $table_column[] = $key;
            $data_table[$key] = $value;
        }

        $data[] = [
            'name' => 'FGS Stock',
            'data' => $tmp_data2,
            'showInLegend' => false
        ];

        return $this->render('fgs-stock', [
            'data' => $data,
            'data_table' => $data_table,
            'table_column' => $table_column,
            'categories' => $categories
        ]);
    }
    public function getLineArr()
    {
        $tmp_data = MasalahPcb::find()
        ->where('line_pcb IS NOT NULL')
        ->andWhere(['<>', 'line_pcb', ''])
        ->groupBy('line_pcb')
        ->orderBy('line_pcb')
        ->all();

        $data_arr = [];

        foreach ($tmp_data as $key => $value) {
            $data_arr[$value->line_pcb] = $value->line_pcb;
        }

        return $data_arr;
    }

    public function actionDefectDailyPcbGetRemark($post_date, $line_pcb)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>NG Detail <small>(' . $post_date . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">No.</th>
            <th class="text-center">Kode Laporan</th>
            <th class="text-center">GMC</th>
            <th class="text-center">PCB</th>
            <th class="text-center">NG Found</th>
            <th class="text-center">Side</th>
            <th class="text-center">Qty</th>
            <th>Problem</th>
            <th>Cause</th>
        </tr>';

        $data_arr = MasalahPcb::find()
        ->where([
            'date(created_date)' => $post_date,
            'line_pcb' => $line_pcb,
            'ng_found' => 'FCT'
        ])
        ->orderBy('created_date')
        ->all();

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center">' . $no . '</td>
                <td class="text-center">' . $value->kode_laporan_pcb . '</td>
                <td class="text-center">' . $value->kode_gmc . '</td>
                <td class="text-center">' . $value->pcb . '</td>
                <td class="text-center">' . $value->ng_found . '</td>
                <td class="text-center">' . $value->side . '</td>
                <td class="text-center">' . $value->qty_pcb . '</td>
                <td>' . $value->problem_pcb . '</td>
                <td>' . $value->cause_pcb . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionDefectDailyPcb($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $model = new \yii\base\DynamicModel([
            'year', 'month', 'line_pcb'
        ]);
        $model->addRule(['year', 'month', 'line_pcb'], 'required');
        if (\Yii::$app->request->get('line') !== null) {
            $model->line_pcb = \Yii::$app->request->get('line');
        }

        $model->month = date('m');
        $model->year = date('Y');
        $pcb_line_arr = $this->getLineArr();
        if ($model->load($_GET) || \Yii::$app->request->get('line') !== null)
        {
            $period = $model->year . $model->month;

            $ng_daily = MasalahPcb::find()
            ->select([
                'post_date' => 'CAST(created_date AS date)',
                'total' => 'COUNT(kode_laporan_pcb)'
            ])
            ->where([
                'EXTRACT(year_month FROM created_date)' => $period,
                'line_pcb' => $model->line_pcb,
                'ng_found' => 'FCT'
            ])
            ->groupBy('post_date')
            ->orderBy('post_date')
            ->all();

            foreach ($ng_daily as $key => $value) {
                $post_date = (strtotime($value->post_date . " +7 hours") * 1000);
                $tmp_data[] = [
                    'x' => $post_date,
                    'y' => (int)$value->total,
                    'url' => Url::to(['defect-daily-pcb-get-remark', 'post_date' => $value->post_date, 'line_pcb' => $model->line_pcb]),
                ];
            }

            $data = [
                [
                    'name' => 'Total NG',
                    'data' => $tmp_data,
                    'color' => 'rgba(255, 0, 0, 0.8)'
                ],
            ];
        }

        return $this->render('defect-daily-pcb', [
            'data' => $data,
            'model' => $model,
            'month_arr' => $month_arr,
            'pcb_line_arr' => $pcb_line_arr
        ]);
    }
    public function actionIotTimeline($machine_id = 'MNT00078')
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        $data[] = [
            'name' => 'TEST',
            'data' => [
                [
                    'x' => (int)strtotime('2019-07-01') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-02') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-03') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-04') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
                [
                    'x' => (int)strtotime('2019-07-05') * 1000,
                    'y' => (int)1,
                    'color' => 'red'
                ],
            ],
        ];
        return $data;
    }

    public function actionLSeriesDaily()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $categories = $data = $tmp_data = [];

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . ' -1 month'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d') . ' -1 month'));

        $model->load($_GET);

        $tmp_serno_output = SernoOutput::find()
        ->joinWith('sernoMaster')
        ->select([
            'etd', 'dst',
            'vms' => 'MIN(vms)',
            'total_qty' => 'datediff(etd, MIN(vms))'
        ])
        ->where([
            'line' => 'L85'
        ])
        ->andWhere(['>=', 'etd', $model->from_date])
        ->andWhere(['<=', 'etd', $model->to_date])
        ->groupBy('etd, dst')
        ->orderBy('etd, dst')
        ->all();

        foreach ($tmp_serno_output as $key => $value) {
            $total_qty = $value->total_qty;
            if ($total_qty > 0) {
                if ($total_qty > 40) {
                    $total_qty -= 33;
                } elseif ($total_qty > 35) {
                    $total_qty -= 27;
                } elseif ($total_qty > 30) {
                    $total_qty -= 23;
                } elseif ($total_qty > 25) {
                    $total_qty -= 17;
                } elseif ($total_qty > 20) {
                    $total_qty -= 13;
                } elseif ($total_qty > 10) {
                    $total_qty -= 7;
                }
                $categories[] = $value->etd . ' [ ' . $value['dst'] . ' ]';
                $tmp_data[] = [
                    'y' => (int)$total_qty
                ];
            }
            
        }

        $data[] = [
            'name' => 'Production Lead Time L-Series',
            'data' => $tmp_data,
            'showInLegend' => false
        ];

        return $this->render('l-series-daily', [
            'data' => $data,
            'model' => $model,
            'categories' => $categories,
        ]);
    }
    public function actionGoMachineOrderCompletion()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];
        $categories = [];

        $driver_arr = GojekTbl::find()
        ->where([
            'SOURCE' => 'MCH'
        ])
        ->orderBy('HADIR DESC, GOJEK_DESC')
        ->all();

        $tmp_data = [];

        foreach ($driver_arr as $value) {
            $nik = $value->GOJEK_ID;
            $order_data_arr = GojekOrderView01::find()
            ->select([
                'GOJEK_ID',
                'GOJEK_DESC',
                'request_ymd',
                'stat_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
                'stat_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
                'stat_total' => 'COUNT(STAT)'
            ])
            ->where([
                'GOJEK_ID' => $nik,
            ])
            ->andWhere(['>=', 'request_ymd', date('Y-m-d', strtotime(date('Y-m-d') . '-10 days'))])
            ->groupBy('GOJEK_ID, GOJEK_DESC, request_ymd')
            ->orderBy('GOJEK_DESC, request_ymd')
            ->asArray()
            ->all();

            $total_point = 0;
            if (count($order_data_arr) > 0) {
                foreach ($order_data_arr as $order_data) {
                    if ($order_data['request_ymd'] == date('Y-m-d') && $nik == $order_data['GOJEK_ID']) {
                        $total_point = $order_data['stat_close'];
                    }
                    $issued_date = (strtotime($order_data['request_ymd'] . " +7 hours") * 1000);
                    $tmp_data[$nik]['open'][] = [
                        'x' => $issued_date,
                        'y' => $order_data['stat_open'] == 0 ? null : (int)$order_data['stat_open'],
                        'url' => Url::to(['get-remark', 'request_ymd' => $order_data['request_ymd'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'O']),
                    ];
                    $tmp_data[$nik]['close'][] = [
                        'x' => $issued_date,
                        'y' => $order_data['stat_close'] == 0 ? null : (int)$order_data['stat_close'],
                        'url' => Url::to(['get-remark', 'request_ymd' => $order_data['request_ymd'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'C']),
                    ];
                    $tmp_data[$nik]['nama'] = $order_data['GOJEK_DESC'];
                }
            } else {
                $tmp_data[$nik]['open'] = null;
                $tmp_data[$nik]['close'] = null;
                $tmp_data[$nik]['nama'] = $value->GOJEK_DESC;
            }
            $tmp_data[$nik]['last_stage'] = $value->STAGE;
            $tmp_data[$nik]['from_loc'] = $value->from_loc;
            $tmp_data[$nik]['to_loc'] = $value->to_loc;
            $tmp_data[$nik]['last_update'] = $value->LAST_UPDATE;
            $tmp_data[$nik]['hadir'] = $value->HADIR;
            $tmp_data[$nik]['todays_point'] = $total_point;
        }

        $fix_data = [];
        foreach ($tmp_data as $key => $value) {
            $fix_data[$key]['data'] = [
                [
                    'name' => 'OPEN',
                    'data' => $value['open'],
                    'color' => 'rgba(255, 0, 0, 0.6)'
                ],
                [
                    'name' => 'CLOSE',
                    'data' => $value['close'],
                    'color' => 'rgba(0, 255, 0, 0.6)'
                ]
            ];
            $fix_data[$key]['nama'] = $value['nama'];
            $fix_data[$key]['last_stage'] = $value['last_stage'];
            $fix_data[$key]['from_loc'] = $value['from_loc'];
            $fix_data[$key]['to_loc'] = $value['to_loc'];
            $fix_data[$key]['last_update'] = $value['last_update'];
            $fix_data[$key]['hadir'] = $value['hadir'];
            //$fix_data[$key]['todays_point'] = isset($driver_point_arr[$key]) ? $driver_point_arr[$key] : 0;
            $fix_data[$key]['todays_point'] =  $value['todays_point'];
        }

        return $this->render('go-machine-order-completion', [
            //'data' => $data,
            'categories' => $categories,
            'max_order' => $max_order,
            'tmp_data' => $tmp_data,
            'fix_data' => $fix_data,
        ]);
    }

    public function getPostingShift($end_date)
    {
        if ($end_date >= date('Y-m-d 07:00:00') && $end_date <= date('Y-m-d 15:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 1;
        }
        if ($end_date >= date('Y-m-d 16:00:00') && $end_date <= date('Y-m-d 21:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 2;
        }
        if ($end_date <= date('Y-m-d 06:59:59') && $end_date >= date('Y-m-d 00:00:00')) {
            $return_data['posting_shift'] = date('Y-m-d', strtotime('-1 day'));
            $return_data['shift'] = 3;
        }
        if ($end_date >= date('Y-m-d 22:00:00') && $end_date <= date('Y-m-d 23:59:59')) {
            $return_data['posting_shift'] = date('Y-m-d');
            $return_data['shift'] = 3;
        }
        return $return_data;
    }

    public function actionCurrentStatus()
    {
        date_default_timezone_set('Asia/Jakarta');
        $get_posting_shift = $this->getPostingShift(date('Y-m-d H:i:s'));
        $posting_shift = $get_posting_shift['posting_shift'];
        $tmp_data = MachineIotCurrent::find()->orderBy('kelompok, mesin_description')->asArray()->all();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $working_time_arr = MachineIotCurrentEffLog::find()
        ->select([
            'mesin_id', 'shift',
            'hijau' => 'SUM(hijau)'
        ])
        ->where([
            'posting_shift' => $posting_shift
        ])
        ->groupBy('mesin_id, shift')
        ->asArray()
        ->all();

        $qty_arr = MachineIotOutput::find()
        ->select([
            'posting_shift', 'shift', 'mesin_id', 'mesin_description',
            'lot_qty' => 'SUM(lot_qty)'
        ])
        ->where([
            'posting_shift' => $posting_shift
        ])
        ->groupBy('posting_shift, shift, mesin_id, mesin_description')
        ->asArray()
        ->all();

        $current_job_data = MachineIotOutput::find()
        ->where('end_date IS NULL')
        ->asArray()
        ->all();

        $tmp_working_time = [];
        $tmp_qty_arr = [];
        $tmp_gmc_desc = [];
        $tmp_btn_class = [];
        foreach ($tmp_data as $key => $value) {
            $btn_class = 'btn btn-lg btn-block bg-gray';
            $bg_color = \Yii::$app->params['bg-gray'];
            if($value['status_warna'] == 'KUNING'){
                //background_color = 'yellow';
                $btn_class = 'btn btn-lg btn-block bg-yellow';
                $bg_color = \Yii::$app->params['bg-yellow'];
            } else if ($value['status_warna'] == 'HIJAU') {
                $btn_class = 'btn btn-lg btn-block bg-green';
                $bg_color = \Yii::$app->params['bg-green'];
            } else if ($value['status_warna'] == 'BIRU') {
                $btn_class = 'btn btn-lg btn-block bg-blue';
                $bg_color = \Yii::$app->params['bg-blue'];
            } else if ($value['status_warna'] == 'MERAH') {
                $btn_class = 'btn btn-lg btn-block bg-red';
                $bg_color = \Yii::$app->params['bg-red'];
            }
            $tmp_btn_class[$value['mesin_id'] . '_mesin_desc'] = '<button type="button" class="' . $btn_class . '">' . $value['mesin_description'] . ' - ' . $value['mesin_id'] . '</button>';
            for ($i = 1; $i <= 3; $i++) { 
                $working_time_pct = 0;
                foreach ($working_time_arr as $key => $working_time) {
                    if ($value['mesin_id'] == $working_time['mesin_id'] && $working_time['shift'] == $i) {
                        if ($i == 2) {
                            $total_work_time = 5 * 3600;
                        } else {
                            $total_work_time = 8 * 3600;
                        }
                        $working_time_pct = round(($working_time['hijau'] / $total_work_time) * 100);
                    }
                }
                if ($working_time_pct <= 50) {
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['content'] = $working_time_pct == 0 ? '' : '<span class="" style="">' . $working_time_pct . '</span>';
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['parent_class'] = $working_time_pct == 0 ? '' : 'bg-red text-center';
                } else {
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['content'] = $working_time_pct == 0 ? '' : '<span class="" style="">' . $working_time_pct . '</span>';
                    $tmp_working_time[$value['mesin_id'] . '_shift' . $i . '_working_time']['parent_class'] = $working_time_pct == 0 ? '' : 'bg-green text-center';
                }

                $tmp_qty = 0;
                foreach ($qty_arr as $key => $qty) {
                    if ($value['mesin_id'] == $qty['mesin_id'] && $qty['shift'] == $i) {
                        $tmp_qty = $qty['lot_qty'];
                    }
                }
                $tmp_qty_arr[$value['mesin_id'] . '_shift' . $i . '_qty'] = $tmp_qty == 0 ? '' : number_format($tmp_qty);
            }

            $tmp_current_job = '';
            foreach ($current_job_data as $key => $current_job) {
                if ($value['mesin_id'] == $current_job['mesin_id']) {
                    $tmp_current_job = $current_job['gmc'] . ' - ' . $current_job['gmc_desc'] . ' (' . number_format($current_job['lot_qty']) . ' PCS)';
                }
            }
            $tmp_gmc_desc[$value['mesin_id'] . '_gmc_desc'] = $tmp_current_job;
            
        }
        
        $data = [
            'working_time' => $tmp_working_time,
            'lot_qty' => $tmp_qty_arr,
            'gmc_desc' => $tmp_gmc_desc,
            'btn_class' => $tmp_btn_class
        ];
        return $data;
    }

    public function actionGetMachineStatus($mesin_id = 'MNT00078', $posting_date = '2019-07-03')
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $data_iot_arr = MachineIot::find()
        ->select([
            'mesin_id', 'mesin_description', 'system_date_time', 'status_warna'
        ])
        ->where([
            'mesin_id' => $mesin_id,
            'posting_date' => $posting_date,
            //'jam_no' => 10
        ])
        ->asArray()
        ->all();

        $current_color = '';
        $mesin_description = '';
        foreach ($data_iot_arr as $key => $value2) {
            $proddate = (strtotime($value2['system_date_time'] . " +7 hours") * 1000);
            $current_color = $value2['status_warna'];
            $mesin_description = $value2['mesin_description'];
            $color = 'rgba(0, 0, 0, 1)';
            if ($value2['status_warna'] == 'PUTIH') {
                $color = 'rgba(255, 255, 255, 1)';
            } elseif ($value2['status_warna'] == 'HIJAU') {
                $color = 'rgba(0, 255, 0, 1)';
            } elseif ($value2['status_warna'] == 'KUNING') {
                $color = 'rgba(255, 255, 0, 1)';
            } elseif ($value2['status_warna'] == 'BIRU') {
                $color = 'rgba(0, 0, 255, 1)';
            } elseif ($value2['status_warna'] == 'MERAH') {
                $color = 'rgba(255, 0, 0, 1)';
            }
            $tmp_data[] = [
                'x' => $proddate,
                'y' => 1,
                'color' => $color
            ];
        }

        $data = [
            'title' => $mesin_description,
            'current_color' => $current_color,
            'series' => [
                [
                    'name' => $mesin_description,
                    'data' => $tmp_data
                ]
            ],
        ];
        
        return $data;
    }
    public function actionMachineRealtimeStatus()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';

        $current_arr = MachineIotCurrent::find()->orderBy('kelompok, mesin_description')->asArray()->all();

        foreach ($current_arr as $key => $value) {
            $machine_arr[$value['mesin_id']] = $value['mesin_description'];
        }

        return $this->render('machine-realtime-status', [
            'data' => $data,
            'machine_arr' => $machine_arr,
            'current_arr' => $current_arr,
        ]);
    }
    public function actionContainerLoading()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';

        $model = new \yii\base\DynamicModel([
            'post_date'
        ]);
        $model->addRule(['post_date'], 'required');

        $model->post_date = date('Y-m-d');

        if ($model->load($_GET)) {
            # code...
        }

        $tmp_data = SernoOutput::find()
        ->joinWith('sernoCnt')
        ->select([
            'cntr',
            'dst' => 'tb_serno_output.dst',
            'status' => 'IFNULL(status, 1.5)',
            'start',
            'tgl',
            'line',
            'gate',
            'remark' => 'tb_serno_cnt.remark',
        ])
        ->where([
            'etd' => $model->post_date
        ])
        ->andWhere(['<>', 'back_order', 2])
        ->groupBy('cntr')
        ->orderBy('status, tb_serno_cnt.remark DESC, gate, line')
        ->asArray()
        ->all();

        return $this->render('container-loading', [
            'data' => $data,
            'model' => $model,
            'tmp_data' => $tmp_data
        ]);
    }

    public function actionMachineStatusRange()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $data = [];
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'machine_id', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','machine_id'], 'required');
        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');
        $model->machine_id = 'MNT00076';

        if (\Yii::$app->request->get('from_date') !== null) {
            $model->from_date = \Yii::$app->request->get('from_date');
        }
        if (\Yii::$app->request->get('to_date') !== null) {
            $model->to_date = \Yii::$app->request->get('to_date');
        }
        if (\Yii::$app->request->get('machine_id') !== null) {
            $model->machine_id = \Yii::$app->request->get('machine_id');
        }

        if ($model->load($_GET)) {
            
        }

        $iot_by_hours = MachineIotCurrentEffLog::find()
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->andWhere(['<=', 'posting_shift', $model->to_date])
        ->asArray()
        ->all();

        $avg_arr = MachineIotCurrentEffLog::find()
        ->select([
            'period_shift',
            'hijau' => 'SUM(hijau)',
            'hijau_biru' => 'SUM(hijau_biru)',
            'total' => 'SUM(total)',
        ])
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->groupBy('period_shift')
        ->all();

        $avg_arr_data = [];
        foreach ($avg_arr as $key => $value) {
            $pct = 0;
            if ($value->hijau_biru > 0) {
                $pct = round(($value->hijau / $value->hijau_biru) * 100);
            }
            $avg_arr_data[$value->period_shift] = $pct;
        }

        $begin = new \DateTime($model->from_date);
        $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date . ' +1 day')));

        $tmp_data_by_hours = [];
        $tmp_avg_hijau = [];

        foreach ($iot_by_hours as $key => $value) {
            $jam = str_pad($value['jam'], 2, '0', STR_PAD_LEFT);
            $his = $jam . ':00:00';
            $ymd_his = date('Y-m-d', strtotime($value['posting_date'])) . ' ' . $his;
            $proddate = (strtotime($ymd_his . " +7 hours") * 1000);

            $avg_hijau_pct = $avg_arr_data[date('Ym', strtotime($value['posting_date']))];

            $total_putih = round($value['putih'] / 60, 1);
            $total_biru = round($value['biru'] / 60, 1);
            $total_kuning = round($value['kuning'] / 60, 1);
            $total_hijau = round($value['hijau'] / 60, 1);
            $total_merah = round($value['merah'] / 60, 1);
            $total_lost = round($value['lost_data'] / 60, 1);

            $tmp_data_by_hours['merah'][] = [
                'x' => $proddate,
                'y' => $total_merah == 0 ? null : $total_merah
            ];
            $tmp_data_by_hours['putih'][] = [
                'x' => $proddate,
                'y' => $total_putih == 0 ? null : $total_putih
            ];
            $tmp_data_by_hours['biru'][] = [
                'x' => $proddate,
                'y' => $total_biru == 0 ? null : $total_biru
            ];
            $tmp_data_by_hours['kuning'][] = [
                'x' => $proddate,
                'y' => $total_kuning == 0 ? null : $total_kuning
            ];
            $tmp_data_by_hours['hijau'][] = [
                'x' => $proddate,
                'y' => $total_hijau == 0 ? null : $total_hijau
            ];
            $tmp_data_by_hours['lost'][] = [
                'x' => $proddate,
                'y' => $total_lost == 0 ? null : $total_lost
            ];
            $tmp_avg_hijau[] = [
                'x' => $proddate,
                'y' => $avg_hijau_pct
            ];
            
        }

        $data_iot_by_hours = [
            [
                'name' => 'UNKNOWN',
                'data' => $tmp_data_by_hours['lost'],
                'color' => 'rgba(0, 0, 0, 0)',
                'dataLabels' => [
                    'enabled' => false
                ],
                'showInLegend' => false,
                'type' => 'column'
            ],
            [
                'name' => 'IDLE',
                'data' => $tmp_data_by_hours['putih'],
                'color' => 'silver',
                'type' => 'column'
            ],
            [
                'name' => 'STOP',
                'data' => $tmp_data_by_hours['merah'],
                'color' => 'red',
                'type' => 'column'
            ],
            [
                'name' => 'HANDLING',
                'data' => $tmp_data_by_hours['kuning'],
                'color' => 'yellow',
                'type' => 'column'
            ],
            [
                'name' => 'SETTING',
                'data' => $tmp_data_by_hours['biru'],
                'color' => 'blue',
                'type' => 'column'
            ],
            [
                'name' => 'RUNNING',
                'data' => $tmp_data_by_hours['hijau'],
                'color' => 'green',
                'type' => 'column'
            ],
            [
                'name' => 'RUNNING [ AVG ]',
                'data' => $tmp_avg_hijau,
                'color' => 'rgba(0, 255, 10, 0.8)',
                'type' => 'line',
                'marker' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'valueSuffix' => '%'
                ],
            ],
        ];

        $machine_iot_util = MachineIotCurrentEffLog::find()
        ->select([
            'posting_shift',
            'merah' => 'SUM(merah)',
            'kuning' => 'SUM(kuning)',
            'hijau' => 'SUM(hijau)',
            'biru' => 'SUM(biru)',
            'putih' => 'SUM(putih)',
            'lost_data' => 'SUM(lost_data)'
        ])
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->andWhere(['<=', 'posting_shift', $model->to_date])
        ->groupBy('posting_shift')
        ->orderBy('posting_shift')
        ->asArray()
        ->all();

        $start_date = (strtotime($model->from_date . " +7 hours") * 1000);
        $end_date = (strtotime($model->to_date . " +7 hours") * 1000);

        $tmp_data = [];
        foreach ($machine_iot_util as $key => $value) {
            $proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
            $total_putih = round($value['putih'] / 60, 1);
            $total_biru = round(($value['biru']) / 60, 1);
            $total_kuning = round(($value['kuning']) / 60, 1);
            $total_hijau = round($value['hijau'] / 60, 1);
            $total_merah = round($value['merah'] / 60, 1);
            $total_sisa = round($value['lost_data'] / 60, 1);

            $tmp_data['PUTIH'][] = [
                'x' => $proddate,
                'y' => $total_putih == 0 ? null : $total_putih
            ];
            $tmp_data['BIRU'][] = [
                'x' => $proddate,
                'y' => $total_biru == 0 ? null : $total_biru
            ];
            $tmp_data['KUNING'][] = [
                'x' => $proddate,
                'y' => $total_kuning == 0 ? null : $total_kuning
            ];
            $tmp_data['HIJAU'][] = [
                'x' => $proddate,
                'y' => $total_hijau == 0 ? null : $total_hijau
            ];
            $tmp_data['MERAH'][] = [
                'x' => $proddate,
                'y' => $total_merah == 0 ? null : $total_merah
            ];
            $tmp_data['sisa'][] = [
                'x' => $proddate,
                'y' => $total_sisa == 0 ? null : $total_sisa
            ];
        }

        $data_iot = [];
        $data_iot = [
            [
                'name' => 'UNKNOWN',
                'data' => $tmp_data['sisa'],
                'color' => 'rgba(0, 0, 0, 0)',
                'dataLabels' => [
                    'enabled' => false
                ],
                'showInLegend' => false,
            ],
            [
                'name' => 'IDLE',
                'data' => $tmp_data['PUTIH'],
                'color' => 'silver'
            ],
            [
                'name' => 'STOP',
                'data' => $tmp_data['MERAH'],
                'color' => 'red'
            ],
            [
                'name' => 'HANDLING',
                'data' => $tmp_data['KUNING'],
                'color' => 'yellow'
            ],
            [
                'name' => 'SETTING',
                'data' => $tmp_data['BIRU'],
                'color' => 'blue'
            ],
            [
                'name' => 'RUNNING',
                'data' => $tmp_data['HIJAU'],
                'color' => 'green',
            ],
            
        ];

        return $this->render('machine-status-range', [
            'model' => $model,
            'posting_date' => $posting_date,
            'machine_id' => $machine_id,
            'categories' => $categories,
            'data_iot' => $data_iot,
            'data_iot_by_hours' => $data_iot_by_hours,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function actionMachineStatusRangeShift()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        
        $data = [];
        $categories = [];

        $model = new \yii\base\DynamicModel([
            'machine_id', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','machine_id'], 'required');
        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');
        $model->machine_id = 'MNT00076';

        if (\Yii::$app->request->get('from_date') !== null) {
            $model->from_date = \Yii::$app->request->get('from_date');
        }
        if (\Yii::$app->request->get('to_date') !== null) {
            $model->to_date = \Yii::$app->request->get('to_date');
        }
        if (\Yii::$app->request->get('machine_id') !== null) {
            $model->machine_id = \Yii::$app->request->get('machine_id');
        }

        if ($model->load($_GET)) {
            
        }

        $iot_by_hours = MachineIotCurrentEffLog::find()
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->andWhere(['<=', 'posting_shift', $model->to_date])
        ->asArray()
        ->all();

        $avg_arr = MachineIotCurrentEffLog::find()
        ->select([
            'period_shift',
            'hijau' => 'SUM(hijau)',
            'hijau_biru' => 'SUM(hijau_biru)',
            'total' => 'SUM(total)',
        ])
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->groupBy('period_shift')
        ->all();

        $avg_arr_data = [];
        foreach ($avg_arr as $key => $value) {
            $pct = 0;
            if ($value->hijau_biru > 0) {
                $pct = round(($value->hijau / $value->hijau_biru) * 100);
            }
            $avg_arr_data[$value->period_shift] = $pct;
        }

        $begin = new \DateTime($model->from_date);
        $end   = new \DateTime(date('Y-m-d', strtotime($model->to_date . ' +1 day')));

        $tmp_data_by_hours = [];
        $tmp_avg_hijau = [];

        foreach ($iot_by_hours as $key => $value) {
            $jam = str_pad($value['jam'], 2, '0', STR_PAD_LEFT);
            $his = $jam . ':00:00';
            $ymd_his = date('Y-m-d', strtotime($value['posting_date'])) . ' ' . $his;
            $proddate = (strtotime($ymd_his . " +7 hours") * 1000);

            $avg_hijau_pct = $avg_arr_data[date('Ym', strtotime($value['posting_date']))];

            $total_putih = round($value['putih'] / 60, 1);
            $total_biru = round($value['biru'] / 60, 1);
            $total_hijau = round($value['hijau'] / 60, 1);
            $total_merah = round($value['merah'] / 60, 1);
            $total_lost = round($value['lost_data'] / 60, 1);

            $tmp_data_by_hours['merah'][] = [
                'x' => $proddate,
                'y' => $total_merah == 0 ? null : $total_merah
            ];
            $tmp_data_by_hours['putih'][] = [
                'x' => $proddate,
                'y' => $total_putih == 0 ? null : $total_putih
            ];
            $tmp_data_by_hours['biru'][] = [
                'x' => $proddate,
                'y' => $total_biru == 0 ? null : $total_biru
            ];
            $tmp_data_by_hours['hijau'][] = [
                'x' => $proddate,
                'y' => $total_hijau == 0 ? null : $total_hijau
            ];
            $tmp_data_by_hours['lost'][] = [
                'x' => $proddate,
                'y' => $total_lost == 0 ? null : $total_lost
            ];
            $tmp_avg_hijau[] = [
                'x' => $proddate,
                'y' => $avg_hijau_pct
            ];
            
        }

        $data_iot_by_hours = [
            [
                'name' => 'UNKNOWN',
                'data' => $tmp_data_by_hours['lost'],
                'color' => 'rgba(0, 0, 0, 0)',
                'dataLabels' => [
                    'enabled' => false
                ],
                'showInLegend' => false,
                'type' => 'column'
            ],
            [
                'name' => 'IDLE',
                'data' => $tmp_data_by_hours['putih'],
                'color' => 'silver',
                'type' => 'column'
            ],
            [
                'name' => 'STOP',
                'data' => $tmp_data_by_hours['merah'],
                'color' => 'red',
                'type' => 'column'
            ],
            [
                'name' => 'SETTING',
                'data' => $tmp_data_by_hours['biru'],
                'color' => 'blue',
                'type' => 'column'
            ],
            [
                'name' => 'RUNNING',
                'data' => $tmp_data_by_hours['hijau'],
                'color' => 'green',
                'type' => 'column'
            ],
            [
                'name' => 'RUNNING [ AVG ]',
                'data' => $tmp_avg_hijau,
                'color' => 'rgba(0, 255, 10, 0.8)',
                'type' => 'line',
                'marker' => [
                    'enabled' => false
                ],
                'tooltip' => [
                    'valueSuffix' => '%'
                ],
            ],
        ];

        $begin = new \DateTime($model->from_date);
        $end = new \DateTime($model->to_date);

        $machine_iot_util = MachineIotCurrentEffPershiftLog::find()
        ->select([
            'posting_shift', 'shift',
            'merah' => 'SUM(merah)',
            'kuning' => 'SUM(kuning)',
            'hijau' => 'SUM(hijau)',
            'biru' => 'SUM(biru)',
            'putih' => 'SUM(putih)',
            'lost_data' => 'SUM(lost_data)'
        ])
        ->where([
            'mesin_id' => $model->machine_id,
        ])
        ->andWhere(['>=', 'posting_shift', $model->from_date])
        ->andWhere(['<=', 'posting_shift', $model->to_date])
        ->groupBy('posting_shift, shift')
        ->asArray()
        ->all();

        $start_date = (strtotime($model->from_date . " +7 hours") * 1000);
        $end_date = (strtotime($model->to_date . " +7 hours") * 1000);
        $tmp_data = $tmp_data2 = [];
        $categories = [];
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            //$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
            
            for ($j=1; $j <= 3; $j++) { 
                $categories[] = $i->format("Y-m-d") . ' [' . $j . ']';
                $total_putih = 0;
                $total_biru = 0;
                $total_hijau = 0;
                $total_merah = 0;
                $total_sisa = 0;
                foreach ($machine_iot_util as $key => $value) {
                    if (date('Y-m-d', strtotime($value['posting_shift'])) == $i->format("Y-m-d") && $value['shift'] == $j) {
                        $total_putih = round($value['putih'] / 60, 1);
                        $total_biru = round(($value['biru'] + $value['kuning']) / 60, 1);
                        $total_hijau = round($value['hijau'] / 60, 1);
                        $total_merah = round($value['merah'] / 60, 1);
                        $total_sisa = round($value['lost_data'] / 60, 1);
                        break;
                    }
                }
                $tmp_data['PUTIH'][] = [
                    'y' => $total_putih == 0 ? null : $total_putih
                ];
                $tmp_data['BIRU'][] = [
                    'y' => $total_biru == 0 ? null : $total_biru
                ];
                $tmp_data['HIJAU'][] = [
                    'y' => $total_hijau == 0 ? null : $total_hijau
                ];
                $tmp_data['MERAH'][] = [
                    'y' => $total_merah == 0 ? null : $total_merah
                ];
                $tmp_data['sisa'][] = [
                    'y' => $total_sisa == 0 ? null : $total_sisa
                ];
            }
        }

        /*foreach ($machine_iot_util as $key => $value) {
            $proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
            $total_putih = round($value['putih'] / 60, 1);
            $total_biru = round(($value['biru'] + $value['kuning']) / 60, 1);
            $total_hijau = round($value['hijau'] / 60, 1);
            $total_merah = round($value['merah'] / 60, 1);
            $total_sisa = round($value['lost_data'] / 60, 1);

            $tmp_data['PUTIH'][] = [
                'x' => $proddate,
                'y' => $total_putih == 0 ? null : $total_putih
            ];
            $tmp_data['BIRU'][] = [
                'x' => $proddate,
                'y' => $total_biru == 0 ? null : $total_biru
            ];
            $tmp_data['HIJAU'][] = [
                'x' => $proddate,
                'y' => $total_hijau == 0 ? null : $total_hijau
            ];
            $tmp_data['MERAH'][] = [
                'x' => $proddate,
                'y' => $total_merah == 0 ? null : $total_merah
            ];
            $tmp_data['sisa'][] = [
                'x' => $proddate,
                'y' => $total_sisa == 0 ? null : $total_sisa
            ];
        }*/

        
        $data_iot = [
            [
                'name' => 'UNKNOWN',
                'data' => $tmp_data['sisa'],
                'color' => 'rgba(0, 0, 0, 0)',
                'dataLabels' => [
                    'enabled' => false
                ],
                'showInLegend' => false,
            ],
            [
                'name' => 'IDLE',
                'data' => $tmp_data['PUTIH'],
                'color' => 'silver'
            ],
            [
                'name' => 'STOP',
                'data' => $tmp_data['MERAH'],
                'color' => 'red'
            ],
            [
                'name' => 'SETTING',
                'data' => $tmp_data['BIRU'],
                'color' => 'blue'
            ],
            [
                'name' => 'RUNNING',
                'data' => $tmp_data['HIJAU'],
                'color' => 'green',
            ],
            
        ];

        return $this->render('machine-status-range-shift', [
            'model' => $model,
            'posting_date' => $posting_date,
            'machine_id' => $machine_id,
            'categories' => $categories,
            'data_iot' => $data_iot,
            'data_iot_by_hours' => $data_iot_by_hours,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'categories' => $categories,
        ]);
    }

    public function actionGoMachineOrder()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $data = [];

        $model = new \yii\base\DynamicModel([
            'request_date'
        ]);
        $model->addRule(['request_date'], 'required');
        $model->request_date = date('Y-m-d');

        /*if (\Yii::$app->request->get('request_date') !== null) {
            $model->request_date = \Yii::$app->request->get('request_date');
        }*/

        $model->load($_GET);

        $tmp_order_arr = GojekOrderView01::find()
        ->select([
            'request_ymd', 'request_hour',
            'qty_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
            'qty_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
        ])
        ->where([
            'source' => 'MCH',
            'request_ymd' => $model->request_date
        ])
        ->groupBy('request_ymd, request_hour')
        ->orderBy('request_hour')
        ->all();
        //echo $model->request_date;
        //echo count($tmp_order_arr);

        $tmp_data = [];
        foreach ($tmp_order_arr as $key => $value) {
            $tmp_request_date = (strtotime($value->request_ymd . ' ' . $value->request_hour . " +7 hours") * 1000);
            if ($value->qty_open > 0) {
                $tmp_data['open'][] = [
                    'x' => $tmp_request_date,
                    'y' => (int)$value->qty_open,
                    'url' => Url::to(['machine-order-get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'O']),
                ];
            }
            
            if ($value->qty_close > 0) {
                $tmp_data['close'][] = [
                    'x' => $tmp_request_date,
                    'y' => (int)$value->qty_close,
                    'url' => Url::to(['machine-order-get-remark', 'request_ymd' => $value->request_ymd, 'request_hour' => $value->request_hour, 'STAT' => 'C']),
                ];
            }
            
        }

        $data = [
            [
                'name' => 'ORDER (OPEN)',
                'data' => $tmp_data['open'],
                'color' => 'rgba(255, 0, 0, 0.7)',
            ],
            [
                'name' => 'ORDER (CLOSE)',
                'data' => $tmp_data['close'],
                'color' => 'rgba(0, 255, 0, 0.7)',
            ],
        ];

        return $this->render('go-machine-order', [
            'data' => $data,
            'model' => $model,
        ]);
    }

    public function actionMachineOrderGetRemark($request_ymd, $request_hour, $STAT)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($STAT == 'O') {
            $status = 'OPEN';
        } else {
            $status = 'CLOSE';
        }
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>Request ' . $status . ' <small>(' . $request_ymd . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 12px;">
            <th class="text-center">Req. Time</th>
            <th class="text-center">Slip ID</th>
            <th>Location</th>
            <th>Machine</th>
            <th>Model</th>
            <th>Requestor</th>
            <th>Driver</th>
        </tr>';

        $data_arr = GojekOrderView01::find()
        ->where([
            'source' => 'MCH',
            'request_ymd' => $request_ymd,
            'request_hour' => $request_hour,
            'STAT' => $STAT
        ])
        ->orderBy('request_date')
        ->all();

        $no = 1;
        foreach ($data_arr as $key => $value) {
            $remark .= '<tr style="font-size: 12px;">
                <td class="text-center" style="font-weight: bold;">' . date('H:i', strtotime($value->request_date)) . '</td>
                <td class="text-center">' . $value->slip_id . '</td>
                <td>' . $value->to_loc . '</td>
                <td>' . $value->item_desc . '</td>
                <td>' . $value->model . '</td>
                <td>' . $value->NAMA_KARYAWAN . '</td>
                <td>' . $value->GOJEK_DESC . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

    public function actionMachineHourlyRank()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $data = [];
        $last_hour = date('Y-m-d H:i:s', strtotime(' -1 hour'));
        if ((int)date('i') <= 5) {
            $last_hour = date('Y-m-d H:i:s', strtotime($last_hour . ' -1 hour'));
        }

        $posting_date = date('Y-m-d', strtotime($last_hour));
        $jam = date('G', strtotime($last_hour));

        //echo $posting_date . ' || ' . $jam;

        $tmp_eff_arr = MachineIotCurrentEffLog::find()
        ->where([
            'posting_date' => $posting_date,
            'jam' => $jam
        ])
        ->orderBy('pct, mesin_description')
        ->all();

        $tmp_data = [];
        $categories = [];
        foreach ($tmp_eff_arr as $key => $value) {
            $categories[] = $value->mesin_description;
            $tmp_data[] = (int)$value->pct;
        }

        $data = [
            [
                'name' => 'Utility',
                'data' => $tmp_data,
                'color' => 'rgba(0, 255, 0, 0.7)',
                'showInLegend' => false,
            ],
        ];

        return $this->render('machine-hourly-rank', [
            'data' => $data,
            'categories' => $categories,
            'last_hour' => $last_hour,
        ]);
    }

    public function actionMachineDailyRank()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $data = [];
        $last_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));

        $tmp_eff_arr = MachineIotCurrentEffLog::find()
        ->select([
            'posting_shift', 'mesin_id', 'mesin_description',
            'hijau' => 'SUM(hijau)',
            'hijau_biru' => 'SUM(hijau_biru)',
            'hijau_biru_kuning' => 'SUM(hijau_biru + kuning)',
            'pct' => 'AVG(pct)'
        ])
        ->where([
            'posting_shift' => $last_date
        ])
        ->groupBy('mesin_id, mesin_description, posting_shift')
        ->all();

        $tmp_data = [];
        foreach ($tmp_eff_arr as $key => $value) {
            $tmp_util = 0;
            if ($value->hijau_biru_kuning > 0) {
                $tmp_util = round(($value->hijau / $value->hijau_biru_kuning) * 100, 1);
            }
            $tmp_data[$value->mesin_description] = $tmp_util;
        }

        asort($tmp_data);

        $tmp_data2 = [];
        $categories = [];
        foreach ($tmp_data as $key => $value) {
            $categories[] = $key;
            $tmp_data2[] = [
                'y' => $value
            ];
        }

        $data = [
            [
                'name' => 'Utility',
                'data' => $tmp_data2,
                'color' => 'rgba(0, 255, 0, 0.7)',
                'showInLegend' => false,
            ],
        ];
        //print_r($tmp_data);

        return $this->render('machine-daily-rank', [
            'data' => $data,
            'categories' => $categories,
            'last_date' => $last_date,
        ]);
    }

    public function getReceivingCalendarArr($tmp_data, $color, $data, $column_name)
    {
        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'title' => strtoupper($value['vendor_name']) . ' - ' . $value['total_qty'],
                'start' => (strtotime($value[$column_name] . " +7 hours") * 1000),
                'allDay' => true,
                'color' => $color
            ];
        }
        return $data;
    }

    public function actionGetDailyReceiving($category)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        if ($category == 'all') {
            $tmp_data = PlanReceiving::find()
            ->select([
                'receiving_date', 'vendor_name',
                'total_qty' => 'SUM(QTY)'
            ])
            ->where('completed_time IS NULL')
            ->groupBy('receiving_date, vendor_name')
            ->orderBy('receiving_date, vendor_name')
            ->asArray()
            ->all();
        } else {
            $tmp_data = PlanReceiving::find()
            ->select([
                'receiving_date', 'vendor_name',
                'total_qty' => 'SUM(QTY)'
            ])
            ->where('completed_time IS NULL')
            ->andWhere(['vehicle' => $category])
            ->groupBy('receiving_date, vendor_name')
            ->orderBy('receiving_date, vendor_name')
            ->asArray()
            ->all();
        }
        #00c0ef
        $data = [];
        $data = $this->getReceivingCalendarArr($tmp_data, '#00a65a', $data, 'receiving_date');
        /*foreach ($tmp_data as $key => $value) {
            $data[] = [
                'title' => strtoupper($value->vendor_name) . ' - ' . $value->total_qty,
                'start' => (strtotime($value->receiving_date . " +7 hours") * 1000),
                'allDay' => true,
                'color' => '#00a65a'
            ];
        }*/

        if ($category == 'Container') {
            $tmp_cut_off = PlanReceiving::find()
            ->select([
                'cut_off_date', 'vendor_name',
                'total_qty' => 'SUM(QTY)'
            ])
            ->where('completed_time IS NULL')
            ->andWhere(['vehicle' => 'Container'])
            ->andWhere('cut_off_date IS NOT NULL')
            ->groupBy('cut_off_date, vendor_name')
            ->orderBy('cut_off_date, vendor_name')
            ->asArray()
            ->all();
            $data = $this->getReceivingCalendarArr($tmp_cut_off, '#00c0ef', $data, 'cut_off_date');

            $tmp_etd_port = PlanReceiving::find()
            ->select([
                'etd_port_date', 'vendor_name',
                'total_qty' => 'SUM(QTY)'
            ])
            ->where('completed_time IS NULL')
            ->andWhere(['vehicle' => 'Container'])
            ->andWhere('etd_port_date IS NOT NULL')
            ->groupBy('etd_port_date, vendor_name')
            ->orderBy('etd_port_date, vendor_name')
            ->asArray()
            ->all();
            $data = $this->getReceivingCalendarArr($tmp_etd_port, '#605ca8', $data, 'etd_port_date');

            $tmp_eta_port = PlanReceiving::find()
            ->select([
                'eta_port_date', 'vendor_name',
                'total_qty' => 'SUM(QTY)'
            ])
            ->where('completed_time IS NULL')
            ->andWhere(['vehicle' => 'Container'])
            ->andWhere('eta_port_date IS NOT NULL')
            ->groupBy('eta_port_date, vendor_name')
            ->orderBy('eta_port_date, vendor_name')
            ->asArray()
            ->all();
            $data = $this->getReceivingCalendarArr($tmp_eta_port, '#3c8dbc', $data, 'eta_port_date');
        }

        return json_encode($data);
    }

    public function actionReceivingCalendar()
    {
        $this->layout = 'clean';

        $model = new \yii\base\DynamicModel([
            'category'
        ]);
        $model->addRule(['category'], 'required');

        $model->category = 'all';
        if ($model->load($_GET)) {
            # code...
        }

        return $this->render('receiving-calendar', [
            'model' => $model
        ]);
    }

	public function actionProductionMonthlyInspection()
	{
		$this->layout = 'clean';
		$categories = [];

    	$year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $year_now = date('Y');
        $start_year = 2018;
        for ($year = $start_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $periode = $model->year . $model->month;

    	/*$inspection_data_arr = InspectionReportView::find()
    	->where([
    		'periode' => $periode
    	])
    	->andWhere('total_lot_out > 0 OR total_repair > 0')
    	->orderBy('proddate')
    	->all();*/

        $inspection_data_arr = SernoInput::find()
        ->select([
            'period' => 'extract(year_month from proddate)',
            'week_no' => 'week(proddate, 4)',
            'proddate',
            'total_data' => 'COUNT(proddate)',
            'total_no_check' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'\')) then 1 ELSE 0 END))',
            'total_ok' => 'SUM((CASE WHEN ((qa_ng = \'\') and (qa_ok = \'OK\')) then 1 ELSE 0 END))',
            'total_lot_out' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result <> 2)) then 1 ELSE 0 END))',
            'total_repair' => 'SUM((CASE WHEN ((qa_ng <> \'\') and (qa_result = 2)) then 1 ELSE 0 END))',
        ])
        ->where([
            'extract(year_month from proddate)' => $periode
        ])
        ->groupBy('week_no, proddate')
        ->having([

        ])
        ->all();

    	$tmp_data = [];
        $tmp_data2 = [];
    	foreach ($inspection_data_arr as $inspection_data) {
    		$categories[] = $inspection_data->proddate;
    		
    		$tmp_data[] = [
    			'y' => $inspection_data->total_lot_out == 0 ? null : (int)$inspection_data->total_lot_out,
    			'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'LOT OUT'])
    		];
            $tmp_data2[] = [
                'y' => $inspection_data->total_repair == 0 ? null : (int)$inspection_data->total_repair,
                'url' => Url::to(['production-inspection/index', 'proddate' => $inspection_data->proddate, 'status' => 'REPAIR'])
            ];
    	}

    	$data = [
            [
                'name' => 'Repair 個別不良',
                'data' => $tmp_data2,
                'color' => 'rgba(0, 0, 255, 0.5)'
            ],
    		[
    			'name' => 'Lot Out ロットアウト',
    			'data' => $tmp_data,
    			'color' => 'rgba(255, 0, 0, 0.5)'
    		],
            
    	];

    	return $this->render('production-monthly-inspection', [
    		'data' => $data,
    		'categories' => $categories,
    		'model' => $model,
    		'year_arr' => $year_arr,
    		'month_arr' => $month_arr,
    		''
    	]);
	}

    public function actionDprLineEfficiency()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->layout = 'clean';
        $line = 'HS';
        $today = date('Y-m-d');

        $target_eff_arr = \Yii::$app->params['line_eff_target'];
        $target_eff = 100;
        if (isset($target_eff_arr[$line])) {
            $target_eff = $target_eff_arr[$line];
        }

        $data_arr = SernoInput::find()
        ->where([
            'proddate' => $today,
            'line' => $line
        ])
        ->orderBy('waktu')
        ->all();

        $tmp_data = [];
        foreach ($data_arr as $key => $value) {
            $post_time = (strtotime($value->proddate . ' ' . $value->waktu . " +7 hours") * 1000);
            $eff = null;
            if ($value->mp_time > 0) {
                $eff = round(($value->qty_time / $value->mp_time) * 100, 1);
            }

            $tmp_data[] = [
                'x' => $post_time,
                'y' => $eff
            ];
        }

        $series = [
            [
                'data' => $tmp_data,
                'name' => 'Efficiency',
                //'lineWidth' => 0.5
            ],
        ];

        return $this->render('dpr-line-efficiency', [
            'series' => $series,
        ]);
    }

	public function actionPartsPickingStatus()
	{
		$this->layout = 'clean';
		date_default_timezone_set('Asia/Jakarta');
        set_time_limit(500);
    	$data = [];
    	$model = new PickingLocation();
    	$model->location = 'WF01';
    	$model->load($_POST);
    	$dropdown_loc = ArrayHelper::map(VisualPickingView02::find()->select('analyst, analyst_desc')->groupBy('analyst, analyst_desc')->orderBy('analyst_desc ASC')->all(), 'analyst', 'analyst_desc');

    	$visual_picking_arr = VisualPickingView02::find()
    	->where([
    		'year' => date('Y'),
    		'analyst' => $model->location
    	])
    	->orderBy('week ASC, req_date')
    	->all();

    	$week_period = $this->getWeekPeriod($model->location);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
		if (!in_array($this_week, $week_period)) {
			$this_week = end($week_period);
		}

    	foreach ($week_period as $week_no) {
    		$tmp_category = [];
    		$tmp_data_open = [];
    		$tmp_data_close = [];

            $tmp_data_ordered = [];
            $tmp_data_started = [];
            $tmp_data_completed = [];
            $tmp_data_handover = [];
    		foreach ($visual_picking_arr as $visual_picking) {
    			if ($week_no == $visual_picking->week) {
    				$tmp_category[] = date('Y-m-d', strtotime($visual_picking->req_date));

    				$open_qty = $visual_picking->slip_open;
    				$close_qty = $visual_picking->slip_close;

                    $ordered_qty = $visual_picking->total_ordered;
                    $started_qty = $visual_picking->total_started;
                    $completed_qty = $visual_picking->total_completed;
                    $handover_qty = $visual_picking->slip_close;
    				$total_qty = $visual_picking->slip_count;

    				$open_percentage = 0;
    				$close_percentage = 0;

                    $ordered_percentage = 0;
                    $started_percentage = 0;
                    $completed_percentage = 0;
                    $handover_percentage = 0;
    				if ($total_qty > 0) {
    					$open_percentage = round((($open_qty / $total_qty) * 100), 2);
    					$close_percentage = round((($close_qty / $total_qty) * 100), 2);

                        $ordered_percentage = round((($ordered_qty / $total_qty) * 100), 2);
                        $started_percentage = round((($started_qty / $total_qty) * 100), 2);
                        $completed_percentage = round((($completed_qty / $total_qty) * 100), 2);
                        $handover_percentage = round((($handover_qty / $total_qty) * 100), 2);
    				}

                    $tmp_data_ordered[] = [
                        'y' => $ordered_percentage == 0 ? null : $ordered_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, [1, 2], 'O')
                    ];
                    $tmp_data_started[] = [
                        'y' => $started_percentage == 0 ? null : $started_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, 3, 'O')
                    ];
                    $tmp_data_completed[] = [
                        'y' => $completed_percentage == 0 ? null : $completed_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, [4, 5], 'O')
                    ];
                    $tmp_data_handover[] = [
                        'y' => $handover_percentage == 0 ? null : $handover_percentage,
                        //'remark' => $this->partsPickingGetRemark($visual_picking->req_date, $visual_picking->analyst, 5, 'C')
                    ];

    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
                'data' => [
                    [
                        'name' => 'ORDERED （受注）',
                        'data' => $tmp_data_ordered,
                        'color' => 'rgba(200, 200, 200, 0.5)',
                    ],
                    [
                        'name' => 'STARTED (ピッキング中)',
                        'data' => $tmp_data_started,
                        'color' => 'rgba(240, 240, 0, 0.5)',
                    ],
                    [
                        'name' => 'COMPLETED (ピッキング完了)',
                        'data' => $tmp_data_completed,
                        'color' => 'rgba(0, 150, 255, 0.5)',
                    ],
                    [
                        'name' => 'HANDOVER （後工程に引渡し）',
                        'data' => $tmp_data_handover,
                        'color' => 'rgba(0, 240, 0, 0.5)',
                    ],
                ],
    		];
    	}

    	return $this->render('parts-picking-status', [
    		'model' => $model,
    		'dropdown_loc' => $dropdown_loc,
    		'data' => $data,
    		'this_week' => $this_week
    	]);
	}

	public function actionNgReport()
	{
		$this->layout = 'clean';
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}
		$period = $year . $month;

		$corrective_data_arr = MntCorrectiveView::find()
		->where([
			'period' => $period
		])
		->orderBy('period, week_no, issued_date')
		->asArray()
		->all();

		$tmp_data = [];
		foreach ($corrective_data_arr as $key => $corrective_data) {
			$week_no = $corrective_data['week_no'];
			$issued_date = $corrective_data['issued_date'];
			$issued_date2 = (strtotime($issued_date . " +7 hours") * 1000);
			$total_open = $corrective_data['total_open'];
			$total_close = $corrective_data['total_close'];
			$tmp_data[$week_no]['open'][] = [
				'x' => $issued_date2,
				'y' => $total_open == 0 ? null : (int)$total_open,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'O', 'mesin_last_update' => $issued_date]),
                'qty' => $total_open,
			];
			$tmp_data[$week_no]['close'][] = [
				'x' => $issued_date2,
				'y' => (int)$total_close,
				'url' => Url::to(['mesin-check-ng/index', 'repair_status' => 'C', 'mesin_last_update' => $issued_date]),
                'qty' => $total_close,
			];
		}

		$data = [];
		foreach ($tmp_data as $key => $value) {
			$data[$key] = [
				[
					'name' => 'OPEN',
					'data' => $value['open'],
					'color' => 'rgba(200, 200, 200, 0.7)',
				],
				[
					'name' => 'CLOSE',
					'data' => $value['close'],
					'color' => 'rgba(0, 200, 0, 0.7)',
				]
			];
		}

		return $this->render('ng-report', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}

    public function actionMonthlyOvertimeBySectionGetRemark($nik, $nama_karyawan, $period)
    {
        $remark = '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3>' . $nama_karyawan . ' <small>(' . $period . ')</small></h3>
        </div>
        <div class="modal-body">
        ';
        
        $remark .= '<table class="table table-bordered table-striped table-hover">';
        $remark .= '<tr style="font-size: 14px;">
            <th class="text-center">Date</th>
            <th class="text-center">Check In</th>
            <th class="text-center">Check Out</th>
            <th class="text-center">Total Hour</th>
            <th>Job Desc.</th>
        </tr>';

        $overtime_data_arr = SplView::find()
        ->where([
            'NIK' => $nik,
            'PERIOD' => $period,
        ])
        ->orderBy('TGL_LEMBUR')
        ->all();

        $no = 1;
        foreach ($overtime_data_arr as $key => $value) {

            $remark .= '<tr style="font-size: 14px;">
                <td class="text-center">' . date('Y-m-d', strtotime($value->TGL_LEMBUR)) . '</td>
                <td class="text-center">' . date('H:i', strtotime($value->START_LEMBUR_ACTUAL)) . '</td>
                <td class="text-center">' . date('H:i', strtotime($value->END_LEMBUR_ACTUAL)) . '</td>
                <td class="text-center">' . $value->NILAI_LEMBUR_ACTUAL . '</td>
                <td>' . $value->KETERANGAN . '</td>
            </tr>';
            $no++;
        }

        $remark .= '</table>';
        $remark .= '</div>';

        return $remark;
    }

	public function actionMonthlyOvertimeBySection()
	{
		$this->layout = 'clean';
		$model = new \yii\base\DynamicModel([
            'section', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date','section'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));

		if (\Yii::$app->request->get('id') == 'fa') {
			$model->section = '320';
		} elseif (\Yii::$app->request->get('id') == 'pnt') {
			$model->section = '330';
		} elseif (\Yii::$app->request->get('id') == 'ww') {
			$model->section = '300';
		}

		$section_arr = ArrayHelper::map(CostCenter::find()->select('CC_ID, CC_DESC')->groupBy('CC_ID, CC_DESC')->orderBy('CC_DESC')->all(), 'CC_ID', 'CC_DESC');
		$section_arr['ALL'] = '-- ALL SECTIONS --';
		//asort($section_arr);

		if ($model->load($_GET) || \Yii::$app->request->get('id')) {
            $section = $model->section;
            $tmp_categories = SplView::find()
            ->select('PERIOD')
            ->where(['>=', 'PERIOD', date('Ym', strtotime($model->from_date))])
            ->andWhere(['<=', 'PERIOD', date('Ym', strtotime($model->to_date))])
            ->groupBy('PERIOD')
            ->all();
            
            foreach ($tmp_categories as $key => $value) {
                $categories[] = $value->PERIOD;
            }
            if ($section == 'ALL') {
                $karyawan_arr = SplView::find()
                ->select([
                    'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
                ])
                ->where([
                    'PERIOD' => $categories,
                ])
                ->andWhere('NIK IS NOT NULL')
                ->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
                ->asArray()
                ->all();

                $overtime_data = SplView::find()
                ->select([
                    'PERIOD',
                    'NIK',
                    'NAMA_KARYAWAN',
                    'CC_ID',
                    'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
                ])
                ->where([
                    'PERIOD' => $categories,
                ])
                ->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
                ->orderBy('NIK, PERIOD')
                ->asArray()
                ->all();
            } else {
                $karyawan_arr = SplView::find()
                ->select([
                    'NIK', 'NAMA_KARYAWAN', 'CC_ID', 'CC_DESC'
                ])
                ->where([
                    'CC_ID' => $section,
                    'PERIOD' => $categories,
                ])
                ->andWhere('NIK IS NOT NULL')
                ->groupBy('NIK, NAMA_KARYAWAN, CC_ID, CC_DESC')
                ->asArray()
                ->all();

                $overtime_data = SplView::find()
                ->select([
                    'PERIOD',
                    'NIK',
                    'NAMA_KARYAWAN',
                    'CC_ID',
                    'NILAI_LEMBUR_ACTUAL' => 'SUM(NILAI_LEMBUR_ACTUAL)'
                ])
                ->where([
                    'PERIOD' => $categories,
                    'CC_ID' => $section
                ])
                ->groupBy('PERIOD, NIK, NAMA_KARYAWAN, CC_ID')
                ->orderBy('NIK, PERIOD')
                ->asArray()
                ->all();
            }

            foreach ($karyawan_arr as $karyawan) {
                $tmp_data = [];
                foreach ($categories as $period_value) {
                    $hour = 0;
                    foreach ($overtime_data as $value) {
                        if ($value['NIK'] == $karyawan['NIK'] && $period_value == $value['PERIOD']) {
                            $hour = $value['NILAI_LEMBUR_ACTUAL'];
                            continue;
                        }
                    }
                    $tmp_data[] = [
                        'y' => round($hour, 2),
                        'url' => Url::to(['monthly-overtime-by-section-get-remark', 'nik' => $karyawan['NIK'], 'nama_karyawan' => $karyawan['NAMA_KARYAWAN'], 'period' => $period_value])
                    ];
                }
                $data[] = [
                    'name' => $karyawan['NIK'] . ' - ' . $karyawan['NAMA_KARYAWAN'] . ' (' . $karyawan['CC_DESC'] . ')',
                    'data' => $tmp_data,
                    'showInLegend' => false,
                    'lineWidth' => 0.8,
                    'color' => new JsExpression('Highcharts.getOptions().colors[0]')
                ];
            }
        }

        return $this->render('monthly-overtime-by-section', [
            'data' => $data,
            'model' => $model,
            'section' => $section,
            'categories' => $categories,
            'section_arr' => $section_arr
        ]);
	}

	public function actionHrgaSplReportDaily()
	{
		$this->layout = 'clean';
		$title = '';
    	$subtitle = '';
    	$category = [];
    	$data = [];
        $data2 = [];
    	$cc_group_arr = [];
    	$category_arr = [];
    	$tgl_lembur_arr = [];

        $year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = SplView::find()->select([
            'min_year' => 'MIN(FORMAT(TGL_LEMBUR, \'yyyy\'))'
        ])->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        $model->year = date('Y');
        if ($model->load($_GET))
        {

        }

        $period = $model->year . '-' . $model->month;

        $spl_data = SplView::find()
        ->select([
            'TGL_LEMBUR' => 'TGL_LEMBUR',
            'CC_GROUP' => 'CC_GROUP',
            'JUMLAH' => 'COUNT(NIK)',
            'total_lembur' => 'SUM(NILAI_LEMBUR_ACTUAL)'
        ])
        ->where('NIK IS NOT NULL')
        ->andWhere('CC_GROUP IS NOT NULL')
        ->andWhere('NILAI_LEMBUR_ACTUAL IS NOT NULL')
        ->andWhere([
            'FORMAT(TGL_LEMBUR, \'yyyy-MM\')' => $period
        ])
        ->groupBy('CC_GROUP, TGL_LEMBUR')
        ->orderBy('TGL_LEMBUR, CC_GROUP')
        ->all();

        foreach ($spl_data as $value) {
            if(!in_array($value->CC_GROUP, $cc_group_arr)){
                $cc_group_arr[] = $value->CC_GROUP;
            }
            if (!in_array($value->TGL_LEMBUR, $tgl_lembur_arr)) {
                $tgl_lembur_arr[] = $value->TGL_LEMBUR;
            }
        }

        $prod_total_jam_lembur = 0;
        $others_total_jam_lembur = 0;
        foreach ($cc_group_arr as $cc_group) {
            $tmp_data = [];
            $tmp_data2 = [];
            foreach ($tgl_lembur_arr as $tgl_lembur) {
                $is_found = false;
                
                foreach ($spl_data as $value) {
                    if ($tgl_lembur == $value->TGL_LEMBUR && $cc_group == $value->CC_GROUP) {
                        if ($value->CC_GROUP == 'PRODUCTION') {
                            $prod_total_jam_lembur += $value->total_lembur;
                        } else {
                            $others_total_jam_lembur += $value->total_lembur;
                        }
                        $tmp_data[] = [
                            'y' => (int)$value->JUMLAH,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $tmp_data2[] = [
                            'y' => (float)$value->total_lembur,
                            'url' => Url::to(['get-remark', 'tgl_lembur' => $tgl_lembur, 'cc_group' => $cc_group])
                            //'remark' => $this->getDetailEmpRemark($tgl_lembur, $cc_group)
                        ];
                        $is_found = true;
                    }
                }
                if (!$is_found) {
                    $tmp_data[] = null;
                    $tmp_data2[] = null;
                }
                if (!in_array($tgl_lembur, $category_arr)) {
                    $category_arr[] = $tgl_lembur;
                }
            }
            $data[] = [
                'name' => $cc_group,
                'data' => $tmp_data,
            ];
            $data2[] = [
                'name' => $cc_group,
                'data' => $tmp_data2,
            ];
        }

        foreach ($category_arr as $key => $value) {
            $category_arr[$key] = date('j', strtotime($value));
        }

        $overtime_budget = $this->getOvertimeBudget($model->year . $model->month, 1);
        $overtime_budget2 = $this->getOvertimeBudget($model->year . $model->month, 2);

    	return $this->render('hrga-spl-report-daily', [
            'model' => $model,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'category' => $category_arr,
    		'data' => $data,
            'data2' => $data2,
            'year_arr' => $year_arr,
            'month_arr' => $month_arr,
            'prod_total_jam_lembur' => $prod_total_jam_lembur,
            'others_total_jam_lembur' => $others_total_jam_lembur,
            'overtime_budget' => $overtime_budget,
            'overtime_budget2' => $overtime_budget2,
            //'budget_progress' => 120,
            'budget_progress' => $overtime_budget == 0 ? 0 : round((($prod_total_jam_lembur / $overtime_budget) * 100), 2),
            'budget_progress2' => $overtime_budget2 == 0 ? 0 : round((($others_total_jam_lembur / $overtime_budget2) * 100), 2)
    	]);
	}

	public function actionOvertimeMonthlySummary()
	{
		$this->layout = 'clean';
		$searchModel  = new OvertimeMonthlySummarySearch;

		$year = date('Y');
        $month = date('m');

        $searchModel->PERIOD = $year . $month;
        
        if (\Yii::$app->request->get('PERIOD') !== null) {
			$searchModel->PERIOD = \Yii::$app->request->get('PERIOD');
		}

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('overtime-monthly-summary', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

	public function actionTopOvertimeData()
	{
		$this->layout = 'clean';
		$searchModel  = new TopOvertimeDataSearch;

		$year = date('Y');
        $month = date('m');

        $searchModel->PERIOD = $year . $month;
        
        if (\Yii::$app->request->get('PERIOD') !== null) {
			$searchModel->PERIOD = \Yii::$app->request->get('PERIOD');
		}

	    $dataProvider = $searchModel->search($_GET);

		Tabs::clearLocalStorage();

		Url::remember();
		\Yii::$app->session['__crudReturnUrl'] = null;

		return $this->render('top-overtime-data', [
			'dataProvider' => $dataProvider,
		    'searchModel' => $searchModel,
		]);
	}

    public function actionHrComplaint()
    {
        $this->layout = 'clean';
        $searchModel  = new HrComplaintSearch;
        $searchModel->category = 'HR';
        $dataProvider = $searchModel->search($_GET);

        $total_waiting = HrComplaint::find()
        ->where([
            'status' => 0,
            'category' => 'HR',
        ])
        ->count();

        Tabs::clearLocalStorage();

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('hr-complaint', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'total_waiting' => $total_waiting,
        ]);
    }

	/*public function partsPickingGetRemark($req_date, $analyst, $stage_id, $stat)
    {
    	$data_arr = VisualPickingView::find()
    	->where([
    		'req_date' => $req_date,
    		'analyst' => $analyst,
            'stage_id' => $stage_id,
            'stat' => $stat,
    	])
    	->orderBy('set_list_no ASC')
    	->all();

    	$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">Setlist No</th>
			<th class="text-center">Parent</th>
			<th>Parent Description</th>
			<th class="text-center" style="width: 100px;">Req Date</th>
			<th class="text-center">Plan Qty</th>
			<th class="text-center">Part Count</th>
			<th class="text-center">Man Power</th>
            <th class="text-center" style="width:90px;">Start Date</th>
            <th class="text-center" style="width:90px;">Completed Date</th>
			<th class="text-center">Confirm</th>
            <th class="text-center">PTS Note</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
            $req_date = $value['req_date'] == null ? '-' : date('Y-m-d', strtotime($value['req_date']));
            $start_date = $value['start_date'] == null ? '-' : date('Y-m-d H:i:s', strtotime($value['start_date']));
            $completed_date = $value['completed_date'] == null ? '-' : date('Y-m-d H:i:s', strtotime($value['completed_date']));
			$data .= '
				<tr>
					<td class="text-center">' . $value['set_list_no'] . '</td>
					<td class="text-center">' . $value['parent'] . '</td>
					<td>' . $value['parent_desc'] . '</td>
					<td class="text-center">' . $req_date . '</td>
					<td class="text-center">' . $value['plan_qty'] . '</td>
					<td class="text-center">' . $value['part_count'] . '</td>
					<td class="text-center">' . $value['man_power'] . '</td>
                    <td class="text-center">' . $start_date . '</td>
                    <td class="text-center">' . $completed_date . '</td>
					<td class="text-center">' . $value['stage_desc'] . '</td>
                    <td>' . $value['pts_note'] . '</td>
				</tr>
				';
		}

		$data .= '</table>';
		return $data;
    }*/

	public function getWeekPeriod($analyst)
    {
    	$return_arr = [];
    	$data_arr = VisualPickingView02::find()
    	->select('week')
    	->where([
    		'year' => date('Y'),
    		'analyst' => $analyst
    	])
    	->groupBy('week')
    	->all();

    	$selisih = count($data_arr) - 10;

    	$i = 1;
    	foreach ($data_arr as $value) {
    		if ($i > $selisih) {
    			$return_arr[] = $value->week;
    		}
    		$i++;
    	}

    	return $return_arr;
    }

    public function getOvertimeBudget($period, $category_id)
    {
        $data = SplOvertimeBudget::find()
        ->where([
            'period' => $period,
            'category_id' => $category_id
        ])
        ->one();

        return $data->overtime_budget != null ? $data->overtime_budget : 0;
    }
}