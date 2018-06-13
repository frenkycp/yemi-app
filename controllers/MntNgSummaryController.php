<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\MesinNgFreq04;

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
        $today_month = date('n');
        $today_year = date('Y');
    	$category_arr = $this->getCategories();
    	$period_arr = $this->getWeeklyPeriod($today_month, $today_year);
    	
    	$data_ng = MesinNgFreq04::find()
    	->select([
    		'periode_kerusakan' => 'periode_kerusakan',
    		'area' => 'area',
    		'total_freq' => 'SUM(freq_kerusakan)',
    		'total_lama_perbaikan' => 'SUM(lama_perbaikan_menit)'
    	])
        ->where([
            'periode_kerusakan' => date('Ym')
        ])
    	->groupBy('periode_kerusakan, area')
    	->orderBy('periode_kerusakan, area')
    	->all();

    	foreach ($category_arr as $category) {
    		$tmp_data = [];

    		foreach ($period_arr as $period) {
    			$tmp_period = $period;
                $x_axis_name = date('M Y') . ' Week ' . $period;
    			$tmp_total = 0;
    			
    			if (!in_array($x_axis_name, $categories)) {
					$categories[] = $x_axis_name;
				}
				$tmp_data[] = 15;
    		}
    		$data[] = [
    			'name' => $category,
    			'data' => $tmp_data
    		];
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'data' => $data,
    		'categories' => $categories,
            'week_total' => $total_week
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