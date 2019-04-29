<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\SernoOutput;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use yii\helpers\Html;

class MonthlyContainerDisplayController extends Controller
{
	public function actionIndex()
    {
    	$this->layout = 'clean';
    	$data = [];
    	$category = [];
    	//$title = date('F Y');
    	$subtitle = '';

    	$year = date('Y');
		$month = date('m');
		
    	$data_arr = SernoOutput::find()
    	->select([
    		'etd' => 'etd',
    		'cntr' => 'cntr',
    		'total_qty' => 'SUM(qty)',
    		'total_output' => 'SUM(output)'
    	])
    	->where([
    		'LEFT(etd, 7)' => $year . '-' . $month,
    	])
        ->andWhere(['<>', 'back_order', 2])
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
        $total_container = 0;

    	foreach ($data as $key => $value) {
    		$category[] = $key;
    		$data_open = $value['total_open'];
    		$data_close = $value['total_close'];
    		$data_total = $data_open + $data_close;
            $total_container += $data_total;

    		$presentase_open = 0;
    		$presentase_close = 0;
    		if ($data_total > 0) {
    			$presentase_open = round((($data_open / $data_total) * 100), 2);
    			$presentase_close = round((($data_close / $data_total) * 100), 2);
    		}

    		$presentase_open_arr[] = [
    			'y' => $data_open,
    			'qty' => $data_open,
    			'total_qty' => $data_total,
    		];
    		$presentase_close_arr[] = [
    			'y' => $data_close,
    			'qty' => $data_close,
    			'total_qty' => $data_total,
    		];
    	}

    	$final_data = [
    		[
    			'name' => 'OPEN',
    			'data' => $presentase_open_arr,
    			'dataLabels' => [
    				'enabled' => false
    			],
    			'color' => 'rgba(169,169,169, 0.8)',
    			'showInLegend' => false,
    		],[
    			'name' => 'CLOSE',
    			'data' => $presentase_close_arr,
    			'color' => 'rgba(0,200,0,0.6)',
    			'showInLegend' => false,
    		]
    	];

    	return $this->render('index', [
    		'data' => $final_data,
    		'category' => $category,
    		'title' => $title,
    		'subtitle' => $subtitle,
            'total_container' => $total_container
    	]);
    }
}