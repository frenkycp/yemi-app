<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\FiscalTbl;
use app\models\AssetTbl;
use app\models\MttrMtbfDataView;
use app\models\MesinCheckNg;
use app\models\WorkDayTbl;
use app\models\MachineStopRecord;
use app\models\WipEffTbl;
use app\models\WorkingDaysView;
use app\models\MachineKadouritsu;
use app\models\MachineIotLogHour;

class DisplayMntController extends Controller
{
	public function actionKadouritsuGetMachine($loc_id)
	{
		$tmp_machine = MachineKadouritsu::find()->where(['LOC_ID' => $loc_id])->orderBy('MACHINE_NAME')->all();

		if (count($tmp_machine) > 0) {
			echo '<option value="ALL">ALL MACHINE</option>';
            foreach ($tmp_machine as $key => $value) {
                echo "<option value='" . $value->MACHINE_ID . "'>" . $value->MACHINE_ID . " - " . $value->MACHINE_NAME . "</option>";
            }
        } else {
            echo "'<option>-</option>'";
        }
	}

	public function actionKadouritsuDaily($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'location', 'from_date', 'to_date', 'machine'
        ]);
        $model->addRule(['from_date', 'to_date','location', 'machine'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-d');

        $loc_dropdown = [
        	'WI01' => 'INJ. SMALL',
        	'WI02' => 'INJ. LARGE',
        	'WM02' => 'AUTO INSERT',
        	'WM03' => 'SMT',
        ];

        $list_machine = $machine_arr = $tmp_kadouritsu1 = $tmp_kadouritsu2 = $chart_kadouritsu = $tmp_sougyouritsu_arr = $chart_sougyouritsu = $tmp_data_machine = [];
        $machine_dropdown = [];
        if ($model->load($_GET)) {
        	$machine_dropdown = [
        		'ALL' => 'ALL MACHINE'
        	];
        	$tmp_machine = MachineKadouritsu::find()->where(['LOC_ID' => $model->location])->orderBy('MACHINE_NAME')->all();
    		foreach ($tmp_machine as $tmp_val) {
    			$machine_arr[] = $tmp_val->MACHINE_ID;
    			$machine_dropdown[$tmp_val->MACHINE_ID] = $tmp_val->MACHINE_NAME;
    			$tmp_data_machine[$tmp_val->MACHINE_ID] = [
    				'name' => $tmp_val->MACHINE_NAME,
    				'merah' => 0,
    				'kuning' => 0,
    				'hijau' => 0,
    				'biru' => 0,
    				'putih' => 0,
    				'lost_data' => 0,
    			];
    		}

        	if ($model->machine != 'ALL') {
        		$machine_arr = [$model->machine];
        	}

        	$working_day_total = WorkDayTbl::find()
        	->where([
	            'AND',
	            ['>=', 'cal_date', $model->from_date],
	            ['<=', 'cal_date', $model->to_date]
	        ])
	        ->andWhere('holiday IS NULL')
        	->count();

        	$total_time_calendar = $working_day_total * 60 * 24;

        	$log_hour = MachineIotLogHour::find()
        	->select([
        		'mesin_id', 'mesin_description', 'posting_date',
        		'merah' => 'SUM(merah / 60)',
        		'kuning' => 'SUM(kuning / 60)',
        		'hijau' => 'SUM(hijau / 60)',
        		'biru' => 'SUM(biru / 60)',
        		'putih' => 'SUM(putih / 60)',
        		'lost_data' => 'SUM(lost_data / 60)',
        	])
        	->where([
	            'AND',
	            ['>=', 'posting_date', $model->from_date],
	            ['<=', 'posting_date', $model->to_date]
	        ])
	        ->andWhere([
	        	'mesin_id' => $machine_arr
	        ])
	        ->groupBy(['mesin_id', 'mesin_description', 'posting_date'])
	        ->orderBy('posting_date')
        	->all();

        	foreach ($log_hour as $log_val) {
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['merah'] += $log_val->merah;
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['hijau'] += $log_val->hijau;
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['kuning'] += $log_val->kuning;
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['biru'] += $log_val->biru;
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['putih'] += $log_val->putih;
        		$tmp_kadouritsu1[date('Y-m-d', strtotime($log_val->posting_date))]['lost_data'] += $log_val->lost_data;

        		$tmp_data_machine[$log_val->mesin_id]['merah'] += $log_val->merah;
        		$tmp_data_machine[$log_val->mesin_id]['hijau'] += $log_val->hijau;
        		$tmp_data_machine[$log_val->mesin_id]['kuning'] += $log_val->kuning;
        		$tmp_data_machine[$log_val->mesin_id]['biru'] += $log_val->biru;
        		$tmp_data_machine[$log_val->mesin_id]['putih'] += $log_val->putih;
        		$tmp_data_machine[$log_val->mesin_id]['lost_data'] += $log_val->lost_data;
        	}

        	foreach ($tmp_kadouritsu1 as $post_date_val => $value) {
        		$post_date = (strtotime($post_date_val . " +7 hours") * 1000);
        		$penyebut = $value['hijau'] + $value['biru'] + $value['merah'];
        		$tmp_kadouritsu = 0;
        		if ($penyebut > 0) {
        			$tmp_kadouritsu = round(($value['hijau'] / $penyebut) * 100, 1);
        		}
        		$tmp_kadouritsu2[] = [
                    'x' => $post_date,
                    'y' => (float)$tmp_kadouritsu,
                ];

        		$penyebut2 = 60 * 24;
        		$tmp_sougyouritsu = round(($penyebut / $penyebut2) * 100, 1);

        		$tmp_sougyouritsu_arr[] = [
                    'x' => $post_date,
                    'y' => (float)$tmp_sougyouritsu,
                ];
        	}

        	$chart_kadouritsu[] = [
        		'name' => 'Kadouritsu',
        		'data' => $tmp_kadouritsu2,
        		'color' => new JsExpression('Highcharts.getOptions().colors[0]')
        	];

        	$chart_sougyouritsu[] = [
        		'name' => 'Sougyouritsu',
        		'data' => $tmp_sougyouritsu_arr,
        		'color' => new JsExpression('Highcharts.getOptions().colors[1]')
        	];
        }

        return $this->render('kadouritsu-daily', [
        	'model' => $model,
        	'machine_dropdown' => $machine_dropdown,
        	'loc_dropdown' => $loc_dropdown,
        	'chart_kadouritsu' => $chart_kadouritsu,
        	'chart_sougyouritsu' => $chart_sougyouritsu,
        	'tmp_data_machine' => $tmp_data_machine,
        ]);
	}

	public function actionMachineStopMonthlyReport($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        return $this->render('machine-stop-monthly-report', [
        	'model' => $model,
        ]);
	}

	public function actionKadouritsu($value='')
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

        if ($model->load($_GET)) { }

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

        $tmp_wip_data = WipEffTbl::find()
        ->select([
        	'period', 'child_analyst',
        	'total_nett' => 'SUM(lt_nett)',
        	'total_dandori' => 'SUM(dandori)',
        ])
        ->where([
        	'period' => $period_arr,
        	'plan_stats' => 'C'
        ])
        ->groupBy('period, child_analyst')
        ->all();

        /*$working_day_arr = WorkingDaysView::find()
        ->where(['period' => $period_arr])
        //->andWhere(['<='])
        ->all();*/

        $working_day_arr = WorkDayTbl::find()
        ->select([
        	'period' => 'FORMAT(cal_date, \'yyyyMM\')',
        	'total' => 'COUNT(cal_date)'
        ])
        ->where('holiday IS NULL')
        ->andWhere(['FORMAT(cal_date, \'yyyyMM\')' => $period_arr])
        ->andWhere(['<=', 'cal_date', date('Y-m-d')])
        ->groupBy(['FORMAT(cal_date, \'yyyyMM\')'])
        ->all();

        $data = [];
        $kadouritsu_loc_arr = \Yii::$app->params['kadouritsu_loc_arr'];
        foreach ($kadouritsu_loc_arr as $loc_id => $loc_desc) {
        	$data[$loc_id]['loc_desc'] = $loc_desc;
        	foreach ($period_arr as $period_val) {
        		$tmp_working_day = 0;
        		foreach ($working_day_arr as $working_day_val) {
        			if ($working_day_val->period == $period_val) {
        				$tmp_working_day = $working_day_val->total;
        			}
        		}
        		$net_operating_time = $tmp_working_day * 1440;

        		$running_time = $total_dandori = 0;
        		foreach ($tmp_wip_data as $wip_data_val) {
        			if ($wip_data_val->period == $period_val && $wip_data_val->child_analyst == $loc_id) {
        				$running_time = $wip_data_val->total_nett;
        				$total_dandori = $wip_data_val->total_dandori;
        			}
        		}

        		if ($loc_id != 'WM02') {
        			$running_time = $running_time / 2;
        			$total_dandori = $total_dandori / 2;
        		}

        		$tmp_kadouritsu = $ratio_dandori = 0;
        		if ($net_operating_time > 0) {
        			$tmp_kadouritsu = round(($running_time / $net_operating_time) * 100, 1);
        			$ratio_dandori = round(($total_dandori / $net_operating_time) * 100, 1);
        		}

        		$data[$loc_id]['kadouritsu'][$period_val] = $tmp_kadouritsu;
        		$data[$loc_id]['dandori'][$period_val] = $ratio_dandori;
        	}
        }

        return $this->render('kadouritsu', [
        	'model' => $model,
        	'data' => $data,
        	'period_arr' => $period_arr,
        ]);
	}

	public function actionMachineStopTime()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        date_default_timezone_set('Asia/Jakarta');

        $tmp_data = MachineStopRecord::find()->where(['STATUS' => 0])->all();
        $data = [];
        $tbody_content = '';

        if (count($tmp_data) > 0) {
        	foreach ($tmp_data as $key => $value) {
	        	$second_date = new \DateTime(date('Y-m-d H:i:s'));
	            $first_date = new \DateTime($value->START_TIME);
	            $interval = $first_date->diff($second_date);
	            $total_hour = $interval->d * 24;
	            $total_hour += $interval->h;
	            $stopwatch = $total_hour . '<span style="font-size: 0.4em;"> hour</span> ' . $interval->i . '<span style="font-size: 0.4em;"> min</span>';
	            
	            $tbody_content .= '<tr>
                    <td>
                    	<span class="fa fa-gears" style=""></span> ' . $value->MESIN_DESC . '<br/>
                    	<small><span class="fa fa-info-circle" style=""></span> ' . \Yii::$app->params['machine_stop_category'][$value->CATEGORY] . '</small>
                	</td>
                    <td class="machine-stop" style="background-color: red; border-radius: 10px; border: 2px solid white; letter-spacing: 5px;" width="400px"><span class="glyphicon glyphicon-time" style="font-size: 0.65em;"></span> <b><span>' . $stopwatch . '</span></b></td>
                </tr>';
	        }
        }
        

        return [
        	'total_stop' => count($tmp_data),
        	'tbody_content' => $tbody_content
        ];
	}

	public function actionMachineStop()
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $data = MachineStopRecord::find()->where(['STATUS' => 0])->all();

        return $this->render('machine-stop', [
        	'data' => $data
        ]);
	}

	public function actionMachineByArea($fiscal_year)
	{
		\Yii::$app->response->format = Response::FORMAT_JSON;
	    $out = [];
	    if (isset($_POST['depdrop_parents'])) {
	        $parents = $_POST['depdrop_parents'];
	        if ($parents != null) {
	        	$tmp_fiscal_period = FiscalTbl::find()
		        ->where([
		            'FISCAL' => $fiscal_year
		        ])
		        ->orderBy('PERIOD')
		        ->all();
		        
		        $period_arr = [];
		        foreach ($tmp_fiscal_period as $key => $value) {
		            $period_arr[] = $value->PERIOD;
		        }

	            $cat_id = $parents[0];
	            $tmp_data_asset = MesinCheckNg::find()
	            ->select(['mesin_id', 'mesin_nama'])
	            ->where([
	            	'area' => $cat_id,
	            	//'FORMAT(mesin_last_update, \'yyyyMM\')' => $period_arr,
	            ])
	            ->andWhere(['>', 'down_time', 0])
	            ->groupBy('mesin_id, mesin_nama')
	            ->orderBy('mesin_nama')->all();
	            $tmp_data = $tmp_data_selected = [];
	            foreach ($tmp_data_asset as $key => $value) {
	            	$tmp_data_selected[] = $value->mesin_nama . ' | ' . $value->mesin_id;
	            	$tmp_data[] = [
	            		'id' => $value->mesin_nama . ' | ' . $value->mesin_id,
	            		'name' => $value->mesin_nama . ' | ' . $value->mesin_id
	            	];
	            }
	            // the getSubCatList function will query the database based on the
	            // cat_id and return an array like below:
	            // [
	            //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
	            //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
	            // ]
	            return ['output' => $tmp_data, 'selected' => $tmp_data_selected];
	        }
	    }
	    return ['output'=>'', 'selected'=>''];
	}

	public function actionMttrMtbfAvg($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $limit_mttr = 122;
        $limit_mtbf = 7500;

        $model = new \yii\base\DynamicModel([
            'fiscal_year', 'area', 'machine'
        ]);
        $model->addRule(['fiscal_year', 'area', 'machine'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        /*if ($_GET['fiscal'] != null) {
            $model->fiscal_year = $_GET['fiscal'];
        }*/
        $tmp_data_mttr = $data_mttr = $tmp_data_mtbf = $data_mtbf = $categories = [];
        if ($model->load($_POST)) {
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

	        $tmp_working_days = WorkDayTbl::find()
	        ->select([
	        	'period' => 'FORMAT(cal_date, \'yyyyMM\')',
	        	'total' => 'COUNT(cal_date) '
	        ])
	        ->where('holiday IS NULL')
	        ->andWhere([
	        	'FORMAT(cal_date, \'yyyyMM\')' => $period_arr
	        ])
	        ->groupBy(['FORMAT(cal_date, \'yyyyMM\')'])
	        ->all();

	        /*$tmp_mttr_mtbf = MttrMtbfDataView::find()
	        ->select([
	        	'period', 'mttr' => 'AVG(mttr)', 'mtbf' => 'AVG(mtbf)'
	        ])
	        ->where([
	        	'period' => $period_arr,
	        	'area' => $model->area,
	        	'mesin_id' => $model->machine
	        ])
	        ->groupBy('period')
	        ->orderBy('period')
	        ->all();*/

	        $machine_id_arr = [];
	        foreach ($model->machine as $key => $value) {
	        	$id_explode = explode(' | ', $value);
	        	$machine_id_arr[] = $id_explode[1];
	        }

	        $tmp_ng_data = MesinCheckNg::find()
	        ->select([
	        	'period' => 'FORMAT(mesin_last_update, \'yyyyMM\')',
	        	'mesin_id', 'mesin_nama',
	        	'down_time' => 'SUM(down_time)',
	        	'down_time_number' => 'COUNT(*)'
	        ])
	        ->where([
	        	'FORMAT(mesin_last_update, \'yyyyMM\')' => $period_arr,
	        	'mesin_id' => $machine_id_arr
	        ])
	        ->andWhere(['>', 'down_time', 0])
	        ->groupBy(['FORMAT(mesin_last_update, \'yyyyMM\')', 'mesin_id', 'mesin_nama'])
	        //->asArray()
	        ->all();

	        //return json_encode($tmp_ng_data);
	        $mttr_fy_data = $mtbf_fy_data = [];
	        foreach ($period_arr as $period) {
	        	$categories[] = $period;
	        	$avg_mttr = $avg_mtbf = 0;
	        	/*foreach ($tmp_mttr_mtbf as $key => $value) {
		        	if ($value->period == $period) {
		        		$avg_mttr = $value->mttr;
		        		$avg_mtbf = $value->mtbf;
		        	}
		        }*/
		        $working_day_total = 0;
		        foreach ($tmp_working_days as $working_days) {
		        	if ($working_days->period == $period) {
		        		$working_day_total = $working_days->total;
		        	}
		        }
		        $tmp_mttr_arr = $tmp_mtbf_arr = [];
		        $tmp_nama = [];
		        foreach ($tmp_ng_data as $ng_data) {
		        	$tmp_nama[] = $ng_data->mesin_nama;
		        	if ($ng_data->period == $period) {
		        		$tmp_mttr = $tmp_mtbf = 0;
		        		if ($ng_data->down_time_number > 0) {
		        			$tmp_mttr = round(($ng_data->down_time / $ng_data->down_time_number), 2);
		        			$tmp_mtbf = round((($working_day_total * 1220) - $ng_data->down_time) / $ng_data->down_time_number, 2);
		        		}
		        		if ($tmp_mttr > 0) {
		        			$tmp_mttr_arr[] = $tmp_mttr;
		        		}
		        		if ($tmp_mtbf > 0) {
		        			$tmp_mtbf_arr[] = $tmp_mtbf;
		        		}
		        	}
		        }
		        //print_r($tmp_nama);
		        if (count($tmp_mttr_arr) > 0) {
		        	$avg_mttr = round((array_sum($tmp_mttr_arr) / count($tmp_mttr_arr)));
		        }
		        if (count($tmp_mtbf_arr) > 0) {
		        	$avg_mtbf = round((array_sum($tmp_mtbf_arr) / count($tmp_mtbf_arr)));
		        }
		        if ($avg_mttr > 0) {
		        	$mttr_fy_data[] = $avg_mttr;
		        }
		        if ($avg_mtbf > 0) {
		        	$mtbf_fy_data[] = $avg_mtbf;
		        }
		        $tmp_data_mttr[] = [
		        	'y' => $avg_mttr,
		        	'color' => $avg_mttr > $limit_mttr ? 'red' : 'green'
		        ];
		        $tmp_data_mtbf[] = [
		        	'y' => $avg_mtbf,
		        	'color' => $avg_mtbf < $limit_mtbf ? 'red' : 'green'
		        ];
	        }

	        $mttr_fy_avg = $mtbf_fy_avg = 0;
	        if (count($mttr_fy_data) > 0) {
	        	$mttr_fy_avg = round(array_sum($mttr_fy_data) / count($mttr_fy_data));
	        }
	        if (count($mtbf_fy_data) > 0) {
	        	$mtbf_fy_avg = round(array_sum($mtbf_fy_data) / count($mtbf_fy_data));
	        }

	        $data_mttr = [
	        	[
	        		'name' => 'MTTR (AVG)',
	        		'data' => $tmp_data_mttr
	        	],
	        ];

	        $data_mtbf = [
	        	[
	        		'name' => 'MTBF (AVG)',
	        		'data' => $tmp_data_mtbf
	        	],
	        ];
        }

        return $this->render('mttr-mtbf-avg', [
        	'data_mttr' => $data_mttr,
        	'data_mtbf' => $data_mtbf,
        	'model' => $model,
        	'categories' => $categories,
        	'limit_mttr' => $limit_mttr,
        	'limit_mtbf' => $limit_mtbf,
        	'mttr_fy_avg' => $mttr_fy_avg,
        	'mtbf_fy_avg' => $mtbf_fy_avg,
        ]);
	}
}