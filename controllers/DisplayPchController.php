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

class DisplayPchController extends Controller
{
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