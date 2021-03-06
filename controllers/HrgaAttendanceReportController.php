<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\PlanReceivingPeriod;
use app\models\AbsensiTbl;
use yii\web\JsExpression;
use yii\Helpers\Url;
use app\models\SunfishEmpAttendance;
use app\models\SunfishAttendanceData;

class HrgaAttendanceReportController extends Controller
{
	public $category_masuk = ['SHIFT-01', 'SHIFT-02', 'SHIFT-03', 'PULANG TIDAK ABSEN', 'PULANG CEPAT', 'DATANG TERLAMBAT', 'DINAS'];
	public $category_cuti = ['CUTI', 'CUTI KHUSUS', 'CUTI KHUSUS IJIN', 'KELUARGA MENINGGAL', 'MELAHIRKAN', 'KEGUGURAN', 'MENIKAH', 'MENGHITANKAN', 'ISTRI KEGUGURAN/MELAHIRKAN'];
	
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$category = [];
    	$year_arr = [];
		$month_arr = [];
		

		for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = AbsensiTbl::find()->select('MIN(YEAR) as min_year')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

		$model = new \yii\base\DynamicModel([
            'month', 'year'
        ]);
        $model->addRule(['month', 'year'], 'required');
        $model->month = date('m');
        $model->year = date('Y');

		if ($model->load($_GET))
		{

		}

		$period = $model->year . $model->month;

		$tmp_data_absen = [];
		$tmp_data_hadir = [];
		$tmp_data_cuti = [];
		if ($period < '202003') {
			$attendance_report_arr = AbsensiTbl::find()
			->select([
				'DATE' => 'DATE',
				'total_karyawan' => 'SUM(TOTAL_KARYAWAN)',
				'total_kehadiran' => 'SUM(CASE WHEN CATEGORY IN (\'SHIFT-01\', \'SHIFT-02\', \'SHIFT-03\', \'PULANG TIDAK ABSEN\', \'PULANG CEPAT\', \'DATANG TERLAMBAT\', \'DINAS\') THEN 1 ELSE 0 END)',
				'total_cuti' => 'SUM(CASE WHEN CATEGORY IN (\'CUTI\', \'CUTI KHUSUS\', \'KELUARGA MENINGGAL\', \'MELAHIRKAN\', \'KEGUGURAN\', \'MENIKAH\', \'MENGHITANKAN\', \'ISTRI KEGUGURAN/MELAHIRKAN\', \'CUTI KHUSUS IJIN\') THEN 1 ELSE 0 END)'
				//'total_cuti' => 'SUM(CASE WHEN CATEGORY=\'CUTI\' OR CATEGORY=\'CUTI KHUSUS\' OR CATEGORY=\'KELUARGA MENINGGAL\' OR CATEGORY=\'CUTI KHUSUS IJIN\' THEN 1 ELSE 0 END)'
			])
			->where([
				'PERIOD' => $period
			])
			->groupBy('DATE')
			->orderBy('DATE')
			->all();

			foreach ($attendance_report_arr as $attendance_report) {
				$total_absent = $attendance_report->total_karyawan - ($attendance_report->total_kehadiran + $attendance_report->total_cuti);
				/*$presentase_hadir = 0;
				$presentase_cuti = 0;
				if ($attendance_report->total_karyawan > 0) {
					$presentase_hadir = floor((($attendance_report->total_kehadiran / $attendance_report->total_karyawan) * 100));
					$presentase_cuti = round((($attendance_report->total_cuti / $attendance_report->total_karyawan) * 100));
				}*/

				//$category[] = date('j', strtotime($attendance_report->DATE));
				$proddate = (strtotime($attendance_report->DATE . " +7 hours") * 1000);
				//$presentase_absent = 100 - ($presentase_hadir + $presentase_cuti);
				$tmp_data_absen[] = [
					'x' => $proddate,
					//'y' => $presentase_absent == 0 ? null : $presentase_absent,
					'y' => (int)$total_absent,
					//'remark' => $this->getRemark($attendance_report->DATE, 0),
					//'qty' => $attendance_report->total_karyawan - ($attendance_report->total_kehadiran + $attendance_report->total_cuti),
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $attendance_report->DATE, 'category' => 0, 'sunfish' => false]),
				];
				$tmp_data_cuti[] = [
					'x' => $proddate,
					//'y' => $presentase_cuti == 0 ? null : $presentase_cuti,
					'y' => (int)$attendance_report->total_cuti,
					//'remark' => $this->getRemark($attendance_report->DATE, 2),
					//'qty' => $attendance_report->total_cuti,
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $attendance_report->DATE, 'category' => 2, 'sunfish' => false]),
				];
				$tmp_data_hadir[] = [
					'x' => $proddate,
					//'y' => $presentase_hadir == 0 ? null : $presentase_hadir,
					'y' => (int)$attendance_report->total_kehadiran,
					//'remark' => $this->getRemark($attendance_report->DATE, 1),
					//'qty' => $attendance_report->total_kehadiran,
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $attendance_report->DATE, 'category' => 1, 'sunfish' => false]),
				];
				
				
			}
		} else {
			$from_date = date('Y-m-01', strtotime($period . '01'));
        	$to_date = date('Y-m-t', strtotime($period . '05'));
        	$data2 = SunfishAttendanceData::instance()->getDailyAttendanceRange($from_date, $to_date);
        	$tmp_daily_record = [];
        	foreach ($data2 as $tgl => $daily_record) {
        		foreach ($daily_record as $value) {
        			if ($tgl <= date('Y-m-d')) {
        				if (!isset($tmp_daily_record[$tgl][$value['attend_judgement']])) {
		                    $tmp_daily_record[$tgl][$value['attend_judgement']] = 0;
		                }
		                $tmp_daily_record[$tgl][$value['attend_judgement']]++;
        			}
        			
        		}
        	}
        	//return json_encode($tmp_daily_record);

			foreach ($tmp_daily_record as $key => $value) {
				$proddate = (strtotime($key . " +7 hours") * 1000);
				$total_hadir = $total_alpa = $total_cuti = $total_ijin = $total_sakit = 0;
				if (isset($value['P'])) {
					$total_hadir = $value['P'];
				}
				if (isset($value['A'])) {
					$total_alpa = $value['A'];
				}
				if (isset($value['C'])) {
					$total_cuti = $value['C'];
				}
				if (isset($value['I'])) {
					$total_ijin = $value['I'];
				}
				if (isset($value['S'])) {
					$total_sakit = $value['S'];
				}
				//$presentase_absent = 100 - ($presentase_hadir + $presentase_cuti);
				$tmp_data_absen[] = [
					'x' => $proddate,
					//'y' => $presentase_absent == 0 ? null : $presentase_absent,
					'y' => (int)$total_alpa + (int)$total_ijin + (int)$total_sakit,
					//'remark' => $this->getRemark($attendance_report->DATE, 0),
					//'qty' => $attendance_report->total_karyawan - ($attendance_report->total_kehadiran + $attendance_report->total_cuti),
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $key, 'category' => 0, 'sunfish' => true]),
				];
				$tmp_data_cuti[] = [
					'x' => $proddate,
					//'y' => $presentase_cuti == 0 ? null : $presentase_cuti,
					'y' => (int)$total_cuti,
					//'remark' => $this->getRemark($attendance_report->DATE, 2),
					//'qty' => $attendance_report->total_cuti,
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $key, 'category' => 2, 'sunfish' => true]),
				];
				$tmp_data_hadir[] = [
					'x' => $proddate,
					//'y' => $presentase_hadir == 0 ? null : $presentase_hadir,
					'y' => (int)$total_hadir,
					//'remark' => $this->getRemark($attendance_report->DATE, 1),
					//'qty' => $attendance_report->total_kehadiran,
					'year_month' => date('M Y', strtotime($period)),
					'url' => Url::to(['get-remark', 'date' => $key, 'category' => 1, 'sunfish' => true]),
				];
			}
		}

		

		$data = [
    		[
    			'name' => 'ABSENT',
    			'data' => $tmp_data_absen,
    			'dataLabels' => [
    				'enabled' => true,
    				'format' => '{point.percentage:.0f}',
    			],
    			'color' => 'rgba(200, 200, 200, 0.4)',
    			//'showInLegend' => false,
    		],
    		[
    			'name' => 'ON LEAVE',
    			'data' => $tmp_data_cuti,
    			'dataLabels' => [
    				'enabled' => true,
    				'format' => '{point.percentage:.0f}',
    			],
    			'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
    			//'showInLegend' => false,
    		],
    		[
    			'name' => 'PRESENT',
    			'data' => $tmp_data_hadir,
    			'dataLabels' => [
    				'enabled' => true,
    				'format' => '{point.percentage:.0f}',
    			],
    			'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
    			//'showInLegend' => false,
    		]
    	];

    	return $this->render('index', [
    		'model' => $model,
    		'data' => $data,
    		'category' => $category,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'month_arr' => $month_arr,
    		'year_arr' => $year_arr,
    	]);
    }

    public function getAttendCodeDescription($attend_code)
    {
    	if (strpos($attend_code, 'CK15')) {
            $keterangan = 'Saudara Kandung Menikah';
        } elseif (strpos($attend_code, 'CK13')) {
            $keterangan = 'Musibah';
        } elseif (strpos($attend_code, 'CK12')) {
            $keterangan = 'Ibadah Haji / Ziarah Keagamaan';
        } elseif (strpos($attend_code, 'CK11')) {
            $keterangan = 'Keguguran';
        } elseif (strpos($attend_code, 'CK10')) {
            $keterangan = 'Melahirkan';
        } elseif (strpos($attend_code, 'CK1')) {
            $keterangan = 'Keluarga Meninggal';
        } elseif (strpos($attend_code, 'CK2')) {
            $keterangan = 'Keluarga Serumah Meninggal';
        } elseif (strpos($attend_code, 'CK3')) {
            $keterangan = 'Menikah';
        } elseif (strpos($attend_code, 'CK4')) {
            $keterangan = 'Menikahkan';
        } elseif (strpos($attend_code, 'CK5')) {
            $keterangan = 'Menghitankan';
        } elseif (strpos($attend_code, 'CK6')) {
            $keterangan = 'Membaptiskan';
        } elseif (strpos($attend_code, 'CK7')) {
            $keterangan = 'Istri Keguguran / Melahirkan';
        } elseif (strpos($attend_code, 'CK8')) {
            $keterangan = 'Tugas Negara';
        } elseif (strpos($attend_code, 'CK9')) {
            $keterangan = 'Haid';
        } elseif (strpos($attend_code, 'ABS')) {
            $keterangan = 'Alpa';
        } elseif (strpos($attend_code, 'Izin') && !strpos($attend_code, 'PRS')) {
            $keterangan = 'Ijin';
        } elseif (strpos($attend_code, 'SAKIT') && !strpos($attend_code, 'PRS')) {
            $keterangan = 'Sakit';
        } elseif (strpos($attend_code, 'CUTI') && !strpos($attend_code, 'PRS') && !strpos($attend_code, 'Izin')) {
            $keterangan = 'Cuti Tahunan';
        } elseif (strpos($attend_code, 'UPL')) {
            $keterangan = 'Tambahan Cuti Melahirkan';
        }

        return $keterangan;
    }

    public function actionGetRemark($date, $category, $sunfish)
    {
    	if ($category == 1) {
			$filter_arr = $this->category_masuk;
			$filter_sunfish = ['P'];
		} elseif ($category == 2) {
			$filter_arr = $this->category_cuti;
			$filter_sunfish = ['C'];
		} else {
			$tmp = AbsensiTbl::find()->select('DISTINCT(CATEGORY)')->where([
				'DATE' => $date,
			])->all();

			$tmp_arr = [];
			$arr_merge = array_merge($this->category_masuk, $this->category_cuti);
			foreach ($tmp as $value) {
				if (!in_array($value->CATEGORY, $arr_merge)) {
					$tmp_arr[] = $value->CATEGORY;
				}
			}
			$filter_arr = $tmp_arr;

			$filter_sunfish = ['I', 'S', 'A'];
		}

		$attendance_report_arr = [];
		if (!$sunfish) {
    		$tmp_attendance_report_arr = AbsensiTbl::find()->where([
				'DATE' => $date,
			])
			->andWhere(['CATEGORY' => $filter_arr])
			->orderBy('SECTION, NIK')
			->all();

			$total_shift_arr = AbsensiTbl::find()
			->select([
				'SHIFT',
				'total_karyawan' => 'COUNT(NIK)'
			])
			->where([
				'DATE' => $date,
				'CATEGORY' => $filter_arr
			])
			->groupBy('SHIFT')
			->orderBy('SHIFT')
			->all();

			foreach ($tmp_attendance_report_arr as $value) {
				$attendance_report_arr[] = [
					'CHECK_IN' => $value->CHECK_IN,
					'CHECK_OUT' => $value->CHECK_OUT,
					'DATE' => $value->DATE,
					'NIK' => $value->NIK,
					'NAMA_KARYAWAN' => $value->NAMA_KARYAWAN,
					'SECTION' => $value->SECTION,
					'SHIFT' => $value->SHIFT,
					'CATEGORY' => $value->CATEGORY,
				];
			}
    	} else {
    		$tmp_attendance_report_arr = SunfishAttendanceData::instance()->getDailyAttendanceRange($date, $date);
    		if (count($tmp_attendance_report_arr[$date]) > 0) {
    			foreach ($tmp_attendance_report_arr[$date] as $key => $value) {
    				if (in_array($value['attend_judgement'], $filter_sunfish)) {
    					$keterangan = $this->getAttendCodeDescription($value['Attend_Code']);
		    			$attendance_report_arr[] = [
							'CHECK_IN' => $value['starttime'],
							'CHECK_OUT' => $value['endtime'],
							'DATE' => date('Y-m-d', strtotime($value['shiftstarttime'])),
							'NIK' => $value['nik'],
							'NAMA_KARYAWAN' => $value['name'],
							'SECTION' => $value['cost_center'],
							'SHIFT' => $value['shift'],
							'CATEGORY' => $keterangan,
						];
    				}
	    			
	    		}
    		}
    		
    	}

    	

		$data = '<p><b>Date : ' . date('Y-m-d', strtotime($date)) . '</b></p>';

		/*foreach ($total_shift_arr as $total_shift) {
			$shift_name = $total_shift->SHIFT != '' ? $total_shift->SHIFT : '[?]';
			$data .= '<p>Total Shift ' . $shift_name . ' : ' . $total_shift->total_karyawan . '</p>';
		}*/

		$data .= '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr style="font-size: 12px;">
			<th class="text-center">NO</th>
			<th class="text-center">NIK</th>
			<th>Nama Karyawan</th>
			<th class="">Section</th>
			<th class="text-center">Shift</th>
			<th class="text-center">Keterangan</th>
			<th class="text-center">Cek In</th>
			<th class="text-center">Cek Out</th>
		</tr>'
		;
		/*$data .= 
		'<tr style="font-size: 12px;">
			<th class="text-center">NO</th>
			<th class="text-center">NIK</th>
			<th>Nama Karyawan</th>
			<th class="text-center">Section</th>
			<th class="text-center">Shift</th>
			<th class="text-center">Keterangan</th>
			<th class="text-center">Cek In</th>
			<th class="text-center">Cek Out</th>
            <th class="text-center">Bonus</th>
            <th class="text-center">Disiplin</th>
            <th class="text-center" style="width: 100px;">Hari Kerja/<br/>Libur</th>
		</tr>'
		;*/

		$i = 1;
		foreach ($attendance_report_arr as $attendance_report) {
			$check_in = $attendance_report['CHECK_IN'] == null ? '-' : date('H:i', strtotime($attendance_report['CHECK_IN']));
			$check_out = $attendance_report['CHECK_OUT'] == null ? '-' : date('H:i', strtotime($attendance_report['CHECK_OUT']));

			/*if (date('Y-m-d') == date('Y-m-d', strtotime($attendance_report['DATE'])) && $check_out == $check_in) {
				$check_out = '-';
			}

			$bonus = '<i class="fa fa-fw fa-close text-red"></i>';
			if ($attendance_report['BONUS'] == 1) {
				$bonus = '<i class="fa fa-fw fa-check text-green"></i>';
			}

			$disiplin = '<i class="fa fa-fw fa-close text-red"></i>';
			if ($attendance_report['DISIPLIN'] == 1) {
				$disiplin = '<i class="fa fa-fw fa-check text-green"></i>';
			}*/

			$data .= '
				<tr style="font-size: 12px;">
					<td class="text-center">' . $i . '</td>
					<td class="text-center">' . $attendance_report['NIK'] . '</td>
					<td>' . $attendance_report['NAMA_KARYAWAN'] . '</td>
					<td class="">' . $attendance_report['SECTION'] . '</td>
					<td class="text-center">' . $attendance_report['SHIFT'] . '</td>
                    <td class="text-center">' . $attendance_report['CATEGORY'] . '</td>
                    <td class="text-center">' . $check_in . '</td>
                    <td class="text-center">' . $check_out . '</td>
				</tr>
			';
			/*$data .= '
				<tr style="font-size: 12px;">
					<td class="text-center">' . $i . '</td>
					<td class="text-center">' . $attendance_report['NIK'] . '</td>
					<td>' . $attendance_report['NAMA_KARYAWAN'] . '</td>
					<td class="text-center">' . $attendance_report['SECTION'] . '</td>
					<td class="text-center">' . $attendance_report['SHIFT'] . '</td>
                    <td class="text-center">' . $attendance_report['CATEGORY'] . '</td>
                    <td class="text-center">' . $check_in . '</td>
                    <td class="text-center">' . $check_out . '</td>
					<td class="text-center">' . $bonus . '</td>
					<td class="text-center">' . $disiplin . '</td>
					<td class="text-center">' . $attendance_report['DAY_STAT'] . '</td>
				</tr>
			';*/
			$i++;
		}

		$data .= '</table>';

		return $data;
    }

}