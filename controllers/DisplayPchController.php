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

class DisplayPchController extends Controller
{
	public function actionStockTakingProgress($value='')
	{
		$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');
        $tmp_data = $data = [];
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

        if ($model->load($_GET)) {
        	$tmp_variance = PcPiVariance::find()
        	->select([
        		'category', 'dandory_date',
        		'total' => 'COUNT(*)'
        	])
        	->where('category IS NOT NULL')
        	->andWhere([
        		'period' => $model->period
        	])
        	->groupBy('category, dandory_date')
        	->orderBy('category')
        	->all();

        	$tmp_total = 0;
        	foreach ($tmp_variance as $key => $value) {
        		$tmp_total += $value->total;
        	}

        	foreach ($tmp_variance as $key => $value) {
        		$post_date = (strtotime($value->dandory_date . " +7 hours") * 1000);
        		$pct = 0;
        		if ($tmp_total > 0) {
        			$pct = round(($value->total / $tmp_total) * 100, 1);
        		}
        		$tmp_data[] = [
        			'x' => $post_date,
        			'y' => $pct,
        			'category_label' => $value->category
        		];
        	}
        	$data = [
        		[
        			'data' => $tmp_data,
        			'dataLabels' => [
        				'enabled' => true,
        				'formatter' => new JsExpression('function(){ return this.y + "%"; }'),
        			],
        		],
        	];
        }

        return $this->render('stock-taking-progress', [
        	'model' => $model,
        	'data' => $data,
        	'period_dropdown_arr' => $period_dropdown_arr,
        ]);
	}
}