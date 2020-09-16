<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\PcPiVariance;
use app\models\StoreOnhandWsus;
use app\models\StorePiItem;
use app\models\StorePiItemLog;

class DisplayPchController extends Controller
{
    public function actionMonthlyStockTake($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $drilldown = [];
        

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        $period_dropdown_arr = ArrayHelper::map(StorePiItem::find()->select('PI_PERIOD')->where('PI_PERIOD IS NOT NULL')->groupBy('PI_PERIOD')->orderBy('PI_PERIOD DESC')->all(), 'PI_PERIOD', 'PI_PERIOD');

        if ($model->load($_GET)) {

        }

        $tmp_result_arr = StorePiItem::find()
        ->select([
            'total_open' => 'SUM(CASE WHEN PI_STAGE = 0 THEN 1 ELSE 0 END)',
            'total1' => 'SUM(CASE WHEN PI_STAGE = 1 THEN 1 ELSE 0 END)',
            'total2' => 'SUM(CASE WHEN PI_STAGE = 2 THEN 1 ELSE 0 END)',
            'total3' => 'SUM(CASE WHEN PI_STAGE = 3 THEN 1 ELSE 0 END)',
            'total4' => 'SUM(CASE WHEN PI_STAGE = 4 THEN 1 ELSE 0 END)',
            'total_all' => 'COUNT(*)',
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period
        ])
        ->andWhere('PI_STAGE IS NOT NULL')
        ->one();

        $total_all_slip = $tmp_result_arr->total_all;
        $status_arr = [
            0 => [
                'label' => 'OPEN',
                'color' => '#FF0000',
            ],
            1 => [
                'label' => 'COUNT 1',
                'color' => '#ff7300',
            ],
            2 => [
                'label' => 'COUNT 2',
                'color' => '#ffff00',
            ],
            3 => [
                'label' => 'AUDIT 1',
                'color' => '#77ff00',
            ],
            4 => [
                'label' => 'AUDIT 2',
                'color' => '#00ff00',
            ],
        ];

        $data = [
            [
                'name' => $status_arr[1]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total1,
                        'drilldown' => $status_arr[1]['label'],
                        
                    ],
                ],
                'color' => $status_arr[1]['color'],
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total2,
                        'drilldown' => $status_arr[2]['label'],
                        
                    ],
                ],
                'color' => $status_arr[2]['color'],
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total3,
                        'drilldown' => $status_arr[3]['label'],
                        
                    ],
                ],
                'color' => $status_arr[3]['color'],
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total4,
                        'drilldown' => $status_arr[4]['label'],
                        
                    ],
                ],
                'color' => $status_arr[4]['color'],
            ],
            [
                'name' => $status_arr[0]['label'],
                'data' => [
                    [
                        'name' => 'Completion',
                        'y' => (int)$tmp_result_arr->total_open,
                        'drilldown' => $status_arr[0]['label'],
                        
                    ],
                ],
                'color' => $status_arr[0]['color'],
            ],
        ];

        $pic_arr = StorePiItem::find()
        ->select('PIC')
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_PERIOD' => $model->period,
        ])
        ->andWhere(['<>', 'PIC', '-'])
        ->groupBy('PIC')
        ->orderBy('PIC')
        ->all();

        foreach ($status_arr as $key => $status) {
            $tmp_data = [];
            $tmp_drilldown_open = StorePiItem::find()->select([
                'PIC', 'total' => 'COUNT(*)'
            ])
            ->where([
                'SLIP_STAT' => 'USED',
                'PI_PERIOD' => $model->period,
                'PI_STAGE' => $key
            ])
            ->andWhere(['<>', 'PIC', '-'])
            ->groupBy('PIC')->orderBy('PIC')->all();

            foreach ($pic_arr as $pic) {
                $tmp_total_value = 0;
                foreach ($tmp_drilldown_open as $value) {
                    if ($pic->PIC == $value->PIC) {
                        $tmp_total_value = $value->total;
                    }
                }
                $tmp_data[] = [
                    $pic->PIC, (int)$tmp_total_value
                ];
            }
            
            $drilldown[] = [
                'id' => $status['label'],
                'name' => $status['label'],
                'data' => $tmp_data
            ];
        }

        $start_date = date('Y-m-01', strtotime($model->period . '01'));
        $end_date = date('Y-m-t', strtotime($model->period . '01'));
        $today = date('Y-m-d');
        /*if ($today < $end_date) {
            $end_date = $today;
        }*/

        $begin = new \DateTime(date('Y-m-d', strtotime($start_date)));
        $end   = new \DateTime(date('Y-m-d', strtotime($end_date)));
        
        $log_1 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_01_LAST_UPDATE' => 'FORMAT(PI_COUNT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_COUNT_01_LAST_UPDATE')
        ->all();

        $log_2 = StorePiItemLog::find()
        ->select([
            'PI_COUNT_02_LAST_UPDATE' => 'FORMAT(PI_COUNT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_COUNT_02_LAST_UPDATE')
        ->all();

        $log_3 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_01_LAST_UPDATE' => 'FORMAT(PI_AUDIT_01_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_AUDIT_01_LAST_UPDATE')
        ->all();

        $log_4 = StorePiItemLog::find()
        ->select([
            'PI_AUDIT_02_LAST_UPDATE' => 'FORMAT(PI_AUDIT_02_LAST_UPDATE, \'yyyy-MM-dd\')',
            'total_slip' => 'COUNT(*)'
        ])
        ->where([
            'SLIP_STAT' => 'USED',
            'PI_MISTAKE' => 'N'
        ])
        ->groupBy('PI_AUDIT_02_LAST_UPDATE')
        ->all();

        $tmp_data1 = $tmp_data2 = $tmp_data3 = $tmp_data4 = [];
        $tmp_total_slip1 = $tmp_total_slip2 = $tmp_total_slip3 = $tmp_total_slip4 = 0;
        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $tgl = $i->format("Y-m-d");
            $post_date = (strtotime($tgl . " +7 hours") * 1000);
            $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = 0;

            foreach ($log_1 as $key => $value) {
                if ($tgl == $value->PI_COUNT_01_LAST_UPDATE) {
                    $tmp_total_slip1 += $value->total_slip;
                }
            }

            foreach ($log_2 as $key => $value) {
                if ($tgl == $value->PI_COUNT_02_LAST_UPDATE) {
                    $tmp_total_slip2 += $value->total_slip;
                }
            }

            foreach ($log_3 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_01_LAST_UPDATE) {
                    $tmp_total_slip3 += $value->total_slip;
                }
            }

            foreach ($log_4 as $key => $value) {
                if ($tgl == $value->PI_AUDIT_02_LAST_UPDATE) {
                    $tmp_total_slip4 += $value->total_slip;
                }
            }

            if ($total_all_slip > 0) {
                $tmp_pct1 = round(($tmp_total_slip1 / $total_all_slip) * 100, 1);
                $tmp_pct2 = round(($tmp_total_slip2 / $total_all_slip) * 100, 1);
                $tmp_pct3 = round(($tmp_total_slip3 / $total_all_slip) * 100, 1);
                $tmp_pct4 = round(($tmp_total_slip4 / $total_all_slip) * 100, 1);
            }

            if ($tgl > $today) {
                $tmp_pct1 = $tmp_pct2 = $tmp_pct3 = $tmp_pct4 = null;
            }

            $tmp_data1[] = [
                'x' => $post_date,
                'y' => $tmp_pct1
            ];

            $tmp_data2[] = [
                'x' => $post_date,
                'y' => $tmp_pct2
            ];

            $tmp_data3[] = [
                'x' => $post_date,
                'y' => $tmp_pct3
            ];

            $tmp_data4[] = [
                'x' => $post_date,
                'y' => $tmp_pct4
            ];
        }

        $data2 = [
            [
                'name' => $status_arr[1]['label'],
                'data' => $tmp_data1,
                'color' => $status_arr[1]['color']
            ],
            [
                'name' => $status_arr[2]['label'],
                'data' => $tmp_data2,
                'color' => $status_arr[2]['color']
            ],
            [
                'name' => $status_arr[3]['label'],
                'data' => $tmp_data3,
                'color' => $status_arr[3]['color']
            ],
            [
                'name' => $status_arr[4]['label'],
                'data' => $tmp_data4,
                'color' => $status_arr[4]['color']
            ],
        ];

        return $this->render('monthly-stock-take', [
            'model' => $model,
            'data' => $data,
            'data2' => $data2,
            'drilldown' => $drilldown,
            'period_dropdown_arr' => $period_dropdown_arr,
        ]);
    }

    public function getMonthlyStockTakeDrilldown($value='')
    {
        # code...
    }

	public function actionStockTakingProgress($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $tmp_data_open = $tmp_data_close = $data = [];
        $this_period = date('Ym');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');

        $period_dropdown_arr = ArrayHelper::map(PcPiVariance::find()->select('period')->groupBy('period')->orderBy('period DESC')->all(), 'period', 'period');
        if (!isset($period_dropdown_arr[$this_period])) {
        	$period_dropdown_arr[$this_period] = $this_period;
        	krsort($period_dropdown_arr);
        }

        $categories_arr = [];
        if ($model->load($_GET)) {
            if ($model->period == $this_period) {
                $tmp_total = StoreOnhandWsus::find()->where(['MAT_CLASS' => '9040'])->andWhere('category IS NOT NULL')->count();
                $tmp_variance = StoreOnhandWsus::find()->select([
                    'category',
                    'total_open' => 'COUNT(*)',
                    'total_close' => 'SUM(CASE WHEN dandory_date IS NOT NULL THEN 1 ELSE 0 END)'
                ])
                ->where(['MAT_CLASS' => '9040'])
                ->andWhere('category IS NOT NULL')
                ->groupBy('category')
                ->all();

                $total_pct_open = $total_pct_close = 0;
                foreach ($tmp_variance as $key => $value) {
                    $pct_open = $pct_close = 0;
                    if ($tmp_total > 0) {
                        $pct_open = round(($value->total_open / $tmp_total) * 100, 0);
                        $pct_close = round(($value->total_close / $tmp_total) * 100, 0);
                    }

                    $total_pct_open += $pct_open;
                    $total_pct_close += $pct_close;
                    if (!in_array($value->category, $categories_arr)) {
                        $categories_arr[] = $value->category;
                    }

                    $tmp_data_close[] = $pct_close;

                    $tmp_data_open[] = $pct_open;
                }
            } else {
                $tmp_total = PcPiVariance::find()
                ->where('category IS NOT NULL')
                ->andWhere([
                    'period' => $model->period
                ])
                ->count();

                $tmp_variance = PcPiVariance::find()
                ->select([
                    'category',
                    'total_open' => 'COUNT(*)',
                    'total_close' => 'SUM(CASE WHEN dandory_date IS NOT NULL THEN 1 ELSE 0 END)'
                ])
                ->where('category IS NOT NULL')
                ->andWhere([
                    'period' => $model->period
                ])
                ->groupBy('category')
                ->orderBy('category')
                ->all();

                $total_pct_open = $total_pct_close = 0;
                foreach ($tmp_variance as $key => $value) {
                    $pct_open = $pct_close = 0;
                    if ($tmp_total > 0) {
                        $pct_open = round(($value->total_open / $tmp_total) * 100, 0);
                        $pct_close = round(($value->total_close / $tmp_total) * 100, 0);
                    }

                    $total_pct_open += $pct_open;
                    $total_pct_close += $pct_close;
                    if (!in_array($value->category, $categories_arr)) {
                        $categories_arr[] = $value->category;
                    }

                    $tmp_data_close[] = $pct_close;

                    $tmp_data_open[] = $pct_open;
                }
            }

            $tmp_data_open[] = [
                'isSum' => true,
            ];

            $tmp_data_close[] = [
                'isSum' => true,
            ];

            $categories_arr[] = 'Total';
        	
        	$data = [
        		[
                    'name' => 'PLAN',
        			'data' => $tmp_data_open,
        			'dataLabels' => [
        				'enabled' => true,
        				'formatter' => new JsExpression('function(){ return this.y + "%"; }'),
        			],
        		],
                [
                    'name' => 'ACTUAL',
                    'data' => $tmp_data_close,
                    'dataLabels' => [
                        'enabled' => true,
                        'formatter' => new JsExpression('function(){ return this.y + "%"; }'),
                    ],
                ],
        	];

            $data2 = [
                [
                    'name' => 'PLAN',
                    'data' => [
                        [
                            'x' => (strtotime('2020-09-01' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-05' . " +7 hours") * 1000),
                            'y' => 10,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-10' . " +7 hours") * 1000),
                            'y' => 15,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ]
                    ],
                ],
                [
                    'name' => 'ACTUAL',
                    'data' => [
                        [
                            'x' => (strtotime('2020-09-01' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-05' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ],
                        [
                            'x' => (strtotime('2020-09-10' . " +7 hours") * 1000),
                            'y' => 5,
                            'category_label' => 'Tes',
                            'qty' => 0,
                        ]
                    ],
                ],
            ];
        }

        return $this->render('stock-taking-progress', [
        	'model' => $model,
            'categories_arr' => $categories_arr,
        	'data' => $data,
            'data2' => $data2,
        	'period_dropdown_arr' => $period_dropdown_arr,
        ]);
	}
}