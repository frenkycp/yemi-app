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

class DisplayMntController extends Controller
{
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
	            $stopwatch = str_pad($total_hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($interval->i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($interval->s, 2, '0', STR_PAD_LEFT);
	            
	            $tbody_content .= '<tr>
                    <td><span class="fa fa-gears" style=""></span> ' . $value->MESIN_DESC . '</td>
                    <td class="text-center" style="background-color: white; border-radius: 10px;" width="400px"><span class="glyphicon glyphicon-time" style="font-size: 0.65em; color: black;"></span> <b><span style="color: red;">' . $stopwatch . '</span></b></td>
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
	            	'FORMAT(mesin_last_update, \'yyyyMM\')' => $period_arr,
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