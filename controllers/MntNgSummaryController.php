<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\MesinNgFreq04;
use app\models\MesinNgFreq;

/**
 * summary
 */
class MntNgSummaryController extends Controller
{
    public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$categories = [];
        $year = date('Y');
        $month = date('m');
    	$category_arr = $this->getCategories();

        if (\Yii::$app->request->get('year') !== null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') !== null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;
    	$period_arr = $this->getWeeklyPeriod(intval($month), $year);
    	
    	$data_ng_arr = MesinNgFreq04::find()
    	->select([
    		'periode_kerusakan' => 'periode_kerusakan',
    		'area' => 'area',
            'week_no' => 'week_no',
    		'total_freq' => 'SUM(freq_kerusakan)',
    		'total_lama_perbaikan' => 'SUM(lama_perbaikan_menit)'
    	])
        ->where([
            'periode_kerusakan' => $period
        ])
        ->andWhere('area != \'\'')
        ->andWhere('area IS NOT NULL')
    	->groupBy('periode_kerusakan, week_no, area')
    	->orderBy('periode_kerusakan, week_no, area')
    	->all();

    	foreach ($category_arr as $area) {
    		$tmp_data = [];

    		foreach ($period_arr as $week_no) {
    			$tmp_period = $week_no;
                $x_axis_name = date('M Y') . ' Week ' . $week_no;
    			$tmp_total_perbaikan = 0;

                foreach ($data_ng_arr as $data_ng) {
                    if ($week_no == $data_ng->week_no && $area == $data_ng->area) {
                        $tmp_total_perbaikan += (int)$data_ng->total_lama_perbaikan;
                    }
                }
    			
    			if (!in_array($x_axis_name, $categories)) {
					$categories[] = $x_axis_name;
				}

                $detail_data = MesinNgFreq::find()
                ->where([
                    'periode_kerusakan' => $period,
                    'area' => $area,
                    'week_no' => $week_no
                ])
                ->orderBy('lama_perbaikan DESC')
                ->all();

                $remark = '<table class="table table-bordered table-striped table-hover">';
                $remark .= '
                <tr>
                    <th style="width:100px; text-align: center;">Tanggal</th>
                    <th style="text-align: center;">ID Mesin</th>
                    <th>Nama Mesin</th>
                    <th>Catatan Perbaikan</th>
                    <th style="text-align: center;">Lama Perbaikan (menit)</th>
                </tr>
                ';

                foreach ($detail_data as $detail) {
                    $remark .= '
                    <tr>
                        <td class="text-center">' . $detail->tgl_kerusakan . '</td>
                        <td style="text-align: center;">' . $detail->mesin_id . '</td>
                        <td>' . $detail->mesin_nama . '</td>
                        <td>' . $detail->repair_note . '</td>
                        <td style="text-align: center;">' . $detail->lama_perbaikan . '</td>
                    </tr>
                    ';
                }

                $remark .= '</table>';

				$tmp_data[] = [
                    'y' => $tmp_total_perbaikan,
                    'remark' => $remark,
                ];
    		}
    		$data[] = [
    			'name' => $area,
    			'data' => $tmp_data
    		];
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'data' => $data,
    		'categories' => $categories,
            'week_total' => $total_week,
            'year' => $year,
            'month' => $month,
    	]);
    }

    public function weeks($month, $year){
            $firstday = date("w", mktime(0, 0, 0, $month, 1, $year)); 
            $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
            if ($firstday!=0) $count_weeks = 1 + ceil(($lastday-8+$firstday)/7);
            else $count_weeks = 1 + ceil(($lastday-1)/7);
            return $count_weeks;
    } 

    public function getWeeks($date, $rollover)
    {
        $cut = substr($date, 0, 8);
        $daylen = 86400;

        $timestamp = strtotime($date);
        $first = strtotime($cut . "00");
        $elapsed = ($timestamp - $first) / $daylen;

        $weeks = 1;

        for ($i = 1; $i <= $elapsed; $i++)
        {
            $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp = strtotime($dayfind);

            $day = strtolower(date("l", $daytimestamp));

            if($day == strtolower($rollover))  $weeks ++;
        }

        return $weeks;
    }

    public function getWeeklyPeriod($month, $year)
    {
        $period_arr = [];
        $total_week = $this->weeks($month, $year);

        for ($i = 1; $i <= $total_week; $i++) {
            $period_arr[] = $i;
        }

        return $period_arr;
    }

    public function getPeriodArr()
    {
    	$period_arr = [];
    	$start_year = date('Y');
    	$start_month = 4;

    	if ($start_year < 3) {
    		$start_year -= 1;
    	}

    	for ($i = 1; $i <= 1; $i++) {
    		
    		if ($start_month > 12) {
    			$start_month -= 12;
    			$start_year += 1;
    		}

            for ($j = 1; $j <= 4; $j++) {
                $period_arr[] = $start_year . str_pad($start_month, 2, '0', STR_PAD_LEFT) . '_W' . $i;
            }
    		
            $start_month++;
    	}

    	return $period_arr;
    }

    public function getCategories()
    {
    	$categories = [];

    	$area_arr = MesinNgFreq04::find()
    	->select('DISTINCT(area)')
    	->orderBy('area')
    	->all();

    	foreach ($area_arr as $area) {
    		$categories[] = $area->area;
    	}

    	return $categories;
    }
}