<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use app\models\PlanReceivingPeriod;

class ProductionContainerDailyReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
    	$data = [];
    	$category = [];
    	//$title = date('F Y');
    	$subtitle = '';
    	$year_arr = [];
		$month_arr = [];

		for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $min_year = SernoOutput::find()->select('MIN(CAST(LEFT(etd,4) as UNSIGNED)) as `min_year`')->one();

        $year_now = date('Y');
        $star_year = $min_year->min_year;
        for ($year = $star_year; $year <= $year_now; $year++) {
            $year_arr[$year] = $year;
        }

    	$model = new PlanReceivingPeriod();
		$model->month = date('m');
		$model->year = date('Y');
		if ($model->load($_POST))
		{

		}

    	$data_arr = SernoOutput::find()
    	->select([
    		'etd' => 'etd',
    		'cntr' => 'cntr',
    		'total_qty' => 'SUM(qty)',
    		'total_output' => 'SUM(output)'
    	])
    	->where([
    		'LEFT(etd, 7)' => $model->year . '-' . $model->month
    	])
    	->groupBy('etd, cntr')
    	->orderBy('etd, cntr')
    	->all();

    	foreach ($data_arr as $value) {
    		if (!isset($data[$value->etd]['total_open'])) {
    			$data[$value->etd]['total_open'] = 0;
    		}
    		if (!isset($data[$value->etd]['total_close'])) {
    			$data[$value->etd]['total_close'] = 0;
    		}
    		if ($value->total_qty != $value->total_output) {
    			$data[$value->etd]['total_open']++;
    		} else {
    			$data[$value->etd]['total_close']++;
    		}
    	}

    	$presentase_open_arr = [];
    	$presentase_close_arr = [];
    	foreach ($data as $key => $value) {
    		$category[] = $key;
    		$data_open = $value['total_open'];
    		$data_close = $value['total_close'];
    		$data_total = $data_open + $data_close;

    		$presentase_open = 0;
    		$presentase_close = 0;
    		if ($data_total > 0) {
    			$presentase_open = round((($data_open / $data_total) * 100), 2);
    			$presentase_close = round((($data_close / $data_total) * 100), 2);
    		}

    		$presentase_open_arr[] = [
    			'y' => $presentase_open,
    			'qty' => $data_open,
    			'total_qty' => $data_total
    		];
    		$presentase_close_arr[] = [
    			'y' => $presentase_close,
    			'qty' => $data_close,
    			'total_qty' => $data_total
    		];
    	}

    	$final_data = [
    		[
    			'name' => 'OPEN',
    			'data' => $presentase_open_arr,
    			'dataLabels' => [
    				'enabled' => false
    			],
    			'color' => 'rgba(200, 200, 200, 0.4)',
    			'showInLegend' => false,
    		],[
    			'name' => 'CLOSE',
    			'data' => $presentase_close_arr,
    			'color' => 'rgba(72,61,139,0.6)',
    			'showInLegend' => false,
    		]
    	];

    	return $this->render('index', [
    		'model' => $model,
    		'data' => $final_data,
    		'category' => $category,
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'month_arr' => $month_arr,
    		'year_arr' => $year_arr
    	]);
    }
}