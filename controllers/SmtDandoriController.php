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
        $location = 'WM03';
    	$this->layout = 'clean';
    	$today = date('Y-m-d');
    	$year = date('Y');
    	$month = date('m');
        $target_max = 0;
    	

    	if (\Yii::$app->request->get('year') !== null) {
			$year = \Yii::$app->request->get('year');
		}

		if (\Yii::$app->request->get('month') !== null) {
			$month = \Yii::$app->request->get('month');
		}

		if (\Yii::$app->request->get('line') !== null) {
			$line = \Yii::$app->request->get('line');
		}

        if (\Yii::$app->request->get('location') !== null) {
            $location = \Yii::$app->request->get('location');
        }

        $yaxis_max = 30;
        if ($line == '01') {
            $target_max = 25;
        } elseif ($line == '02') {
            $target_max = 15;
        }

        if ($location == 'WI02') {
            $target_max = 100;
            $yaxis_max = 100;
        } elseif ($location == 'WI01') {
            $target_max = 60;
            $yaxis_max = 60;
        }

        $period = $year . $month;

    	$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
		$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

		$tmp_data = [];
        $tmp_data2 = [];
        $tmp_data3 = [];
    	for($i = $begin; $i <= $end; $i->modify('+1 day')){
    		$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
            $lot_avg_time = null;
    		$dandori_data = WipEff03Dandori05::find()
	    	->where([
                'child_analyst' => $location,
	    		'period' => $period,
	    		'LINE' => $line,
	    		'CONVERT(date, post_date)' => $i->format("Y-m-d")
	    	])
	    	->orderBy('post_date ASC')
	    	->one();

	    	$dandori_pct = $dandori_data->dandori_pct;
            $total_gmc = $dandori_data->ITEM;

            if ($total_gmc != null) {
                $lot_avg_time = round((($dandori_data->dandori_second / 60) / $total_gmc));
                if ($lot_avg_time > $yaxis_max) {
                    $yaxis_max = $lot_avg_time;
                }
            }

	    	$tmp_data[] = [
	    		'x' => $proddate,
	    		'y' => $dandori_pct,
	    	];
            $tmp_data2[] = [
                'x' => $proddate,
                'y' => $total_gmc,
            ];
            $tmp_data3[] = [
                'x' => $proddate,
                'y' => $lot_avg_time,
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
                    'format' => '{y} Lot',
                    'color' => 'white',
                    'style' => [
                        'fontSize' => '14px',
                    ]
                    //'allowOverlap' => true
                ],
                'tooltip' => [
                    'valueSuffix' => ' Lot'
                ],
            ],
    		[
    			'name' => 'Dandori Ratio(%) - Target Max. 10%',
    			'data' => $tmp_data,
    			'color' => 'yellow',
                'lineWidth' => 2,
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{y}%',
                    'color' => 'white',
                    'style' => [
                        'fontSize' => '14px',
                    ]
                ],
                'tooltip' => [
                    'valueSuffix' => '%',
                ],
    		],
    	];

        $data2 = [
            [
                'name' => 'Dandori Time',
                'data' => $tmp_data3,
                'dataLabels' => [
                    'enabled' => true,
                    'format' => '{y} min.',
                    'color' => 'white',
                    'style' => [
                        'fontSize' => '13px',
                    ]
                ],
                'tooltip' => [
                    'valueSuffix' => ' min'
                ],
                'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
            ]
        ];

        return $this->render('index', [
        	'data' => $data,
            'data2' => $data2,
        	'year' => $year,
        	'month' => $month,
            'target_max' => $target_max,
            'line' => $line,
            'location' => $location,
            'yaxis_max' => $yaxis_max,
        ]);
    }
}