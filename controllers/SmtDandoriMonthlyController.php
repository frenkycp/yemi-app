<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\WipEff03Dandori05;
use yii\web\JsExpression;

class SmtDandoriMonthlyController extends Controller
{
	public function actionIndex($value='')
	{
		$this->layout = 'clean';
        $model = new \yii\base\DynamicModel([
            'location', 'line', 'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date', 'location', 'line'], 'required');

        $model->from_date = date('Y-m-01', strtotime(date('Y-m-d') . '-1 year'));
        $model->to_date = date('Y-m-t', strtotime(date('Y-m-d')));
        $model->location = 'WM03';
        $model->line = '01';
        $target_max = 0;
        $yaxis_max = 30;

        $tmp_data = $tmp_data2 = $tmp_data3 = $categories = $data = [];
        
        

        if ($model->load($_GET)) {
            
        }

        if ($model->line == '01') {
            $target_max = 25;
        } elseif ($model->line == '02') {
            $target_max = 15;
        }

        if ($model->location == 'WI02') {
            $target_max = 100;
            $yaxis_max = 100;
        } elseif ($model->location == 'WI01') {
            $target_max = 60;
            $yaxis_max = 60;
        }

        $tmp_dandori = WipEff03Dandori05::find()
        ->select([
            'period', 'child_analyst', 'child_analyst_desc', 'LINE',
            'dandori_second' => 'SUM(dandori_second)',
            'SHIFT_TIME' => 'SUM(SHIFT_TIME)',
            'lost_etc' => 'SUM(lost_etc)',
            'AVG_ITEM' => 'AVG(ITEM)',
            'ITEM' => 'SUM(ITEM)',
        ])
        ->where([
            'child_analyst' => $model->location,
            'line' => $model->line
        ])
        ->andWhere([
            'AND',
            ['>=', 'post_date', $model->from_date],
            ['<=', 'post_date', $model->to_date]
        ])
        ->groupBy('period, child_analyst, child_analyst_desc, LINE')
        ->orderBy('period')
        ->all();
        foreach ($tmp_dandori as $key => $value) {
            $categories[] = $value->period;
            $pct = round(($value->dandori_second / ($value->SHIFT_TIME - $value->lost_etc)) * 100);

            if ($value->AVG_ITEM > $yaxis_max) {
                $yaxis_max = (int)$value->AVG_ITEM;
            }

            $lot_avg_time = round((($value->dandori_second / 60) / $value->ITEM));

            $tmp_data[] = [
                'y' => (float)$pct
            ];
            $tmp_data2[] = [
                'y' => round($value->AVG_ITEM)
            ];
            $tmp_data3[] = [
                'y' => $lot_avg_time
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
                    ],
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
            'model' => $model,
            'categories' => $categories,
            'yaxis_max' => $yaxis_max,
            'target_max' => $target_max,
        ]);
	}
}