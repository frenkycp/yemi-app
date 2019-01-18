<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\WipEff03Dandori05;
use yii\web\JsExpression;

class SmtDandoriController extends Controller
{
    public function actionIndex()
    {
    	$data = [];
    	$line = '01';
    	$this->layout = 'clean';
    	$today = date('Y-m-d');
    	$year = date('Y');
    	$month = date('m');
    	

    	if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		if (\Yii::$app->request->get('line') !== null) {
			$line = \Yii::$app->request->get('line');
		}

        $period = $year . $month;

    	$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
		$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

		$tmp_data = [];
        $tmp_data2 = [];
    	for($i = $begin; $i <= $end; $i->modify('+1 day')){
    		$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
    		$dandori_data = WipEff03Dandori05::find()
	    	->where([
	    		'period' => $period,
	    		'LINE' => $line,
	    		'CONVERT(date, post_date)' => $i->format("Y-m-d")
	    	])
	    	->orderBy('post_date ASC')
	    	->one();

	    	$dandori_pct = $dandori_data->dandori_pct;
            $total_gmc = $dandori_data->ITEM;

	    	$tmp_data[] = [
	    		'x' => $proddate,
	    		'y' => $dandori_pct,
	    	];
            $tmp_data2[] = [
                'x' => $proddate,
                'y' => $total_gmc,
            ];
    	}

    	$data = [
            [
                'name' => 'Total Lot',
                'data' => $tmp_data2,
                'yAxis' => 1,
                 'type' => 'column',
                'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{y} items'
                    //'allowOverlap' => true
                ],
            ],
    		[
    			'name' => 'Dandori Utilization',
    			'data' => $tmp_data,
    			'color' => 'yellow',
                'lineWidth' => 2,
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{y} %'
                    //'allowOverlap' => true
                ],
    		],
    	];

        return $this->render('index', [
        	'data' => $data,
        	'year' => $year,
        	'month' => $month,
        ]);
    }
}