<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use app\models\WipDummyView;
/**
 * summary
 */
class HighchartXRangeController extends Controller
{
    public function actionIndex()
    {
    	//$data = [];
    	$categories = [];

    	$dummy_data_arr = WipDummyView::find()->orderBy('due_date DESC')->all();

    	$tmp_data = [];
    	$index = 0;
    	foreach ($dummy_data_arr as $dummy_data) {
    		$categories[] = $dummy_data->parent_analyst;
    		$start_date = date('Y-n-d', strtotime($dummy_data->start_date));
    		$start_date_split = explode('-', $start_date);
    		$due_date = date('Y-n-d', strtotime($dummy_data->due_date));
    		$due_date_split = explode('-', $due_date);
    		$str = '';
    		$tmp_data[] = [
    			'x' => new JsExpression('Date.UTC(' . json_encode($start_date_split[0]) . ', ' . json_encode($start_date_split[1] - 1) . ', ' . json_encode($start_date_split[2]) . ')'),
    			'x2' => new JsExpression('Date.UTC(' . json_encode($due_date_split[0]) . ', ' . json_encode($due_date_split[1] - 1) . ', ' . json_encode($due_date_split[2]) .')'),
    			'y' => $index,
    			'partialFill' => 0.25
    		];
    		$index++;
    	}

    	$data = [
    		[
	    		'name' => 'Project 1',
		        // pointPadding => 0,
		        // groupPadding => 0,
		        'borderColor' => 'gray',
		        'pointWidth' => 20,
		        'data' => $tmp_data,
		        'dataLabels' => [
		            'enabled' => true
		        ]
	    	]
    	];

    	return $this->render('index', [
    		'data' => $data,
    		'categories' => $categories
    	]);
    }
}