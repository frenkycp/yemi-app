<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;

use app\models\FiscalTbl;
use app\models\MttrMtbfDataView;

class DisplayMntController extends Controller
{
	public function actionMttrMtbfAvg($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'fiscal_year', 'area'
        ]);
        $model->addRule(['fiscal_year', 'area'], 'required');

        $current_fiscal = FiscalTbl::find()->where([
            'PERIOD' => date('Ym')
        ])->one();
        $model->fiscal_year = $current_fiscal->FISCAL;

        /*if ($_GET['fiscal'] != null) {
            $model->fiscal_year = $_GET['fiscal'];
        }*/
        $tmp_data_mttr = $data_mttr = $tmp_data_mtbf = $data_mtbf = $categories = [];
        if ($model->load($_GET)) {
        	$tmp_fiscal_period = FiscalTbl::find()
	        ->where([
	            'FISCAL' => $model->fiscal_year
	        ])
	        ->orderBy('PERIOD')
	        ->all();
	        
	        $period_arr = [];
	        foreach ($tmp_fiscal_period as $key => $value) {
	            $period_arr[] = $value->PERIOD;
	        }

	        $tmp_mttr_mtbf = MttrMtbfDataView::find()
	        ->select([
	        	'period', 'mttr' => 'AVG(mttr)', 'mtbf' => 'AVG(mtbf)'
	        ])
	        ->where([
	        	'period' => $period_arr,
	        	'area' => $model->area
	        ])
	        ->groupBy('period')
	        ->orderBy('period')
	        ->all();

	        foreach ($period_arr as $period) {
	        	$categories[] = $period;
	        	$avg_mttr = $avg_mtbf = 0;
	        	foreach ($tmp_mttr_mtbf as $key => $value) {
		        	if ($value->period == $period) {
		        		$avg_mttr = $value->mttr;
		        		$avg_mtbf = $value->mtbf;
		        	}
		        }
		        $tmp_data_mttr[] = [
		        	'y' => $avg_mttr
		        ];
		        $tmp_data_mtbf[] = [
		        	'y' => $avg_mtbf
		        ];
	        }

	        $data_mttr = [
	        	[
	        		'name' => 'MTTR (AVG)',
	        		'data' => $tmp_data_mttr
	        	],
	        ];

	        $data_mtbf = [
	        	[
	        		'name' => 'MTBF (AVG)',
	        		'data' => $tmp_data_mtbf
	        	],
	        ];
        }

        return $this->render('mttr-mtbf-avg', [
        	'data_mttr' => $data_mttr,
        	'data_mtbf' => $data_mtbf,
        	'model' => $model,
        	'categories' => $categories,
        ]);
	}
}