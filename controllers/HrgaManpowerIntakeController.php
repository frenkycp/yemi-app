<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\MpInOutView02;

class HrgaManpowerIntakeController extends Controller
{
    public function actionIndex()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$data = [];
    	$max_tab = 10;
    	$global_conditions = [
    		'TAHUN' => date('Y')
    	];
    	$week_arr = $this->getWeekPeriodArr($global_conditions, $max_tab);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
        if (!in_array($this_week, $week_arr)) {
            $this_week = end($week_arr);
        }
        $manpower_intake_arr = MpInOutView02::find()
        ->select([
        	'TAHUN' => 'TAHUN',
        	'PERIOD' => 'PERIOD',
        	'WEEK' => 'WEEK',
        	'TANGGAL' => 'TANGGAL',
        	'total' => 'SUM(COUNT)'
        ])
		->where($global_conditions)
		->groupBy('TAHUN, PERIOD, WEEK, TANGGAL')
		->orderBy('PERIOD ASC, WEEK ASC, TANGGAL ASC')
		->all();

		$data_arr = MpInOutView02::find()
        ->where($global_conditions)
		->orderBy('DEPARTEMEN ASC, SECTION ASC, SUB_SECTION ASC, NAMA_KARYAWAN ASC')
		->all();

    	foreach ($week_arr as $week_no) {
    		$tgl_arr = [];
    		$tmp_data_arr = [];
    		foreach ($manpower_intake_arr as $manpower_intake) {
    			if ($manpower_intake->WEEK == $week_no) {
    				$tgl_arr[] = date('Y-m-d', strtotime($manpower_intake->TANGGAL)) . '';
    				$tmp_data_arr[] = [
    					'y' => (int)$manpower_intake->total,
    					'remark' => $this->getRemarks($data_arr, $global_conditions, $manpower_intake->TANGGAL)
    				];
    				/*$tmp_data_arr[] = 10;*/
    			}
    		}

    		$data[$week_no][] = [
    			'category' => $tgl_arr,
    			'data' => [
    				[
    					'name' => 'MANPOWER',
    					'data' => $tmp_data_arr,
    					'showInLegend' => false,
    					'color' => 'rgba(72,61,139,0.6)'
    				]
    				
    			]
    		];
    	}

    	return $this->render('index', [
    		'data' => $data,
    		'this_week' => $this_week
    	]);
    }

    public function getRemarks($data_arr, $global_conditions, $date)
    {
    	

    	$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th>DEPARTEMEN</th>
			<th>SECTION</th>
			<th>SUB SECTION</th>
			<th class="text-center">NIK</th>
			<th>NAMA KARYAWAN</th>
			<th class="text-center">KONTRAK KE</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
			if ($value->TANGGAL == $date) {
				$data .= '
				<tr>
					<td>' . $value['DEPARTEMEN'] . '</td>
					<td>' . $value['SECTION'] . '</td>
					<td>' . $value['SUB_SECTION'] . '</td>
					<td class="text-center">' . $value['NIK'] . '</td>
					<td>' . $value['NAMA_KARYAWAN'] . '</td>
					<td class="text-center">' . $value['KONTRAK_KE'] . '</td>
				</tr>
				';
			}
			
		}

		$data .= '</table>';
		return $data;
    }

    public function getWeekPeriodArr($global_conditions, $max_tab)
    {
    	$data_arr = MpInOutView02::find()
    	->select('DISTINCT(WEEK)')
    	->where($global_conditions)
    	->orderBy('WEEK ASC')
    	->all();
    	$return_arr = [];

    	$selisih = count($data_arr) - $max_tab;

    	$i = 1;
    	foreach ($data_arr as $value) {
    		if ($i > $selisih) {
    			$return_arr[] = $value->WEEK;
    		}
    		
    		$i++;
    	}

    	return $return_arr;
    }
}