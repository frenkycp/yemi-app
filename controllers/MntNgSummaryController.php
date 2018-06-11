<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\MesinNgFreq04;

/**
 * summary
 */
class MntNgSummaryController extends Controller
{
    public function actionIndex()
    {
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$categories = [];
    	$category_arr = $this->getCategories();
    	$period_arr = $this->getPeriodArr();
    	
    	$data_ng = MesinNgFreq04::find()
    	->select([
    		'periode_kerusakan' => 'periode_kerusakan',
    		'area' => 'area',
    		'total_freq' => 'SUM(freq_kerusakan)',
    		'total_lama_perbaikan' => 'SUM(lama_perbaikan_menit)'
    	])
    	->groupBy('periode_kerusakan, area')
    	->orderBy('periode_kerusakan, area')
    	->all();

    	foreach ($category_arr as $category) {
    		$tmp_data = [];

    		foreach ($period_arr as $period) {
    			$tmp_period = $period;
    			$tmp_total = 0;
    			
    			if (!in_array($tmp_period, $categories)) {
    				//$categories[] = $tmp_period;
					$categories[] = date('M Y', strtotime(date($tmp_period)));
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
    		'categories' => $categories
    	]);
    }

    public function getPeriodArr()
    {
    	$period_arr = [];
    	$start_year = date('Y');
    	$start_month = 4;

    	if ($start_year < 3) {
    		$start_year -= 1;
    	}

    	for ($i = 1; $i < 12; $i++) {
    		$start_month++;
    		if ($start_month > 12) {
    			$start_month -= 12;
    			$start_year += 1;
    		}
    		$period_arr[] = $start_year . str_pad($start_month, 2, '0', STR_PAD_LEFT);
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