<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\MpInOutView02;
use app\models\PlanReceivingPeriod;

class HrgaManpowerIntakeController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
    public function actionIndex()
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$data = [];
        $category = [];
    	
        $year_arr = [];
        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = MpInOutView02::find()->select([
            'min_year' => 'MIN(TAHUN)'
        ])->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

        $model = new PlanReceivingPeriod();
        $model->month = date('m');
        //$model->month = '06';
        $model->year = date('Y');
        if ($model->load($_POST))
        {

        }

        $global_conditions = [
            'PERIOD' => $model->year . $model->month
        ];

        $manpower_intake_arr = MpInOutView02::find()
        ->select([
        	'TANGGAL' => 'TANGGAL',
        	'total' => 'SUM(COUNT)'
        ])
		->where($global_conditions)
		->groupBy('TANGGAL')
		->orderBy('TANGGAL ASC')
		->all();

		$data_arr = MpInOutView02::find()
        ->where($global_conditions)
		->orderBy('DEPARTEMEN ASC, SECTION ASC, SUB_SECTION ASC, NAMA_KARYAWAN ASC')
		->all();

        $tmp_data = [];
        foreach ($manpower_intake_arr as $manpower_intake) {
            $tgl = date('Y-m-d', strtotime($manpower_intake->TANGGAL));
            $category[] = $tgl;
            $tmp_data[] = [
                'y' => (int)$manpower_intake->total,
                'remark' => $this->getRemarks($data_arr, $global_conditions, $manpower_intake->TANGGAL)
            ];
        }

        $data = [
            [
                'name' => 'MANPOWER',
                'data' => $tmp_data,
                'showInLegend' => false,
                'color' => 'rgba(72,61,139,0.6)'
            ]
        ];

    	return $this->render('index', [
            'model' => $model,
    		'data' => $data,
            'category' => $category,
            'year_arr' => $year_arr,
            'month_arr' => $month_arr
    	]);
    }

    public function getRemarks($data_arr, $global_conditions, $date)
    {
    	

    	$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
            <th>No</th>
			<th>DEPARTEMEN</th>
			<th>SECTION</th>
			<th>SUB SECTION</th>
			<th class="text-center">NIK</th>
			<th>NAMA KARYAWAN</th>
			<th class="text-center">KONTRAK KE</th>
		</tr>'
		;
        
        $i = 1;
		foreach ($data_arr as $value) {
			if ($value->TANGGAL == $date) {
				$data .= '
				<tr>
                    <td>' . $i . '</td>
					<td>' . $value['DEPARTEMEN'] . '</td>
					<td>' . $value['SECTION'] . '</td>
					<td>' . $value['SUB_SECTION'] . '</td>
					<td class="text-center">' . $value['NIK'] . '</td>
					<td>' . $value['NAMA_KARYAWAN'] . '</td>
					<td class="text-center">' . $value['KONTRAK_KE'] . '</td>
				</tr>
				';
                $i++;
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