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
use app\models\FiscalTbl;
use app\models\WipOutputMonthlyView;
use app\models\WipHdrDtr;
use app\models\ProdNgData;

class DisplayPrdController extends Controller
{
	public function actionWipNgRate()
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $data = [];

        $model = new \yii\base\DynamicModel([
            'fiscal', 'location'
        ]);
        $model->addRule(['fiscal', 'location'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal = $current_fiscal->FISCAL;
        $model->location = ['INJ', 'WP01'];

        if ($model->load($_GET)) {
            
        };

        $tmp_fiscal_period = FiscalTbl::find()
        ->where([
            'FISCAL' => $model->fiscal
        ])
        ->orderBy('PERIOD')
        ->all();
        $period_arr = [];
        foreach ($tmp_fiscal_period as $key => $value) {
            $period_arr[] = $value->PERIOD;
        }

        $tmp_output_monthly = WipOutputMonthlyView::find()
        ->select([
            'child_analyst_group', 'period', 'total_qty' => 'SUM(total_qty)'
        ])
        ->where([
            'child_analyst_group' => $model->location,
            //'period' => $period_arr
        ])
        ->groupBy('child_analyst_group, period')
        ->all();

        foreach ($model->location as $location_val) {
            if ($location_val == 'INJ') {
                $tmp_location = ['WI01', 'WI02', 'WI03'];
            } else {
                $tmp_location = $location_val;
            }

            /*$tmp_output_monthly = WipOutputMonthlyView::find()
            ->select([
                'period', 'total_qty' => 'SUM(total_qty)'
            ])
            ->where([
                'child_analyst' => $tmp_location,
                'period' => $period_arr
            ])
            ->groupBY('period')
            ->orderBy('period')
            ->all();*/

            

            $tmp_total_ng = ProdNgData::find()
            ->select([
                'period',
                'ng_qty' => 'SUM(ng_qty)'
            ])
            ->where([
                'loc_id' => $tmp_location,
                'period' => $period_arr,
                'flag' => 1
            ])
            ->groupBy('period')
            ->orderBy('period')
            ->all();

            foreach ($period_arr as $period_val) {
                $tmp_output = $tmp_ng = 0;
                
                foreach ($tmp_total_ng as $ng_row) {
                    if ($ng_row->period == $period_val) {
                        $tmp_ng = $ng_row->ng_qty;
                    }
                }

                foreach ($tmp_output_monthly as $output_row) {
                    if ($output_row->period == $period_val && $output_row->child_analyst_group == $location_val) {
                        $tmp_output = $output_row->total_qty;
                    }
                }

                $tmp_pct = 0;
                if ($tmp_output > 0) {
                    $tmp_pct = round(($tmp_ng / $tmp_output) * 100, 1);
                }

                $tmp_data[$location_val][] = [
                    'y' => $tmp_pct,
                ];
                /*$data[$location_val][$period_val] = [
                    'output' => $tmp_output,
                    'ng' => $tmp_ng
                ];*/
            }
        }

        foreach ($tmp_data as $key => $value) {
            $data[] = [
                'name' => \Yii::$app->params['ng_rate_location_arr'][$key],
                'data' => $value
            ];
        }

        return $this->render('wip-ng-rate', [
            'data' => $data,
            'model' => $model,
            'period_arr' => $period_arr,
        ]);
    }
}