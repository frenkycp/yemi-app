<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use app\models\SernoLosstime;
use yii\helpers\Url;
use yii\web\JsExpression;

class DprLineEfficiencyDailyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
	
	public function actionIndex()
	{
		$data = [];
		$data_losstime = [];
		$categories = $this->getLineArr();

		$model = new \yii\base\DynamicModel([
	        'proddate'
	    ]);
	    $model->addRule('proddate', 'required')
	    ->addRule('proddate', 'string');

	    $model->proddate = date('Y-m-d');

	    if($model->load(\Yii::$app->request->get())){
	        
	    }

	    $tmp_data = [];
	    $eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->asArray()
	    ->all();

	    $losstime_detail_arr = SernoLosstime::find()
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->orderBy('category, start_time')
	    ->asArray()
	    ->all();

	    $losstime_arr = SernoLosstime::find()
	    ->select([
	    	'line',
	    	'losstime' => 'ROUND(SUM(losstime), 2)'
	    ])
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->andWhere(['<>', 'category', 'UNKNOWN'])
	    ->groupBy('line')
	    ->asArray()
	    ->all();

	    $tmp_data_losstime = [];

	    foreach ($categories as $key => $line) {
		    $eff = 0;
		    foreach ($eff_data_arr as $key2 => $value2) {
		    	if ($value2['line'] == $line) {
		    		$eff = $value2['efficiency'];
		    	}
		    }

		    $losstime_val = 0;
		    foreach ($losstime_arr as $losstime) {
		    	if ($losstime['line'] == $line) {
		    		$losstime_val = $losstime['losstime'];
		    	}
		    }

		    $remark = "<h4>LINE $line<small> ($model->proddate)</small></h4>";
		    $remark .= '<table class="table table-bordered table-striped table-hover table-condensed">';
		    $remark .= '<tr>
		    	<th class="text-center">Start Time</th>
		    	<th class="text-center">End Time</th>
		    	<th class="text-center">Man Power</th>
		    	<th class="text-center">Category</th>
		    	<th class="text-center">Loss Time (min)</th>
		    	<th>Remark</th>
		    </tr>';

		    /**/foreach ($losstime_detail_arr as $value) {
		    	if ($value['line'] == $line) {
		    		$remark .= '<tr>
			    		<td class="text-center">' . $value['start_time'] . '</td>
			    		<td class="text-center">' . $value['end_time'] . '</td>
			    		<td class="text-center">' . $value['mp'] . '</td>
			    		<td class="text-center">' . $value['category'] . '</td>
			    		<td class="text-center">' . $value['losstime'] . '</td>
			    		<td>' . $value['model'] . '</td>
			    	</tr>';
		    	}
		    }

		    $remark .= '</table>';

		    $tmp_data[] = [
		    	'y' => round($eff, 2),
		    	//'remark' => $remark,
		    	'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $model->proddate])
		    ];

		    $tmp_data_losstime[] = [
		    	'y' => round($losstime_val, 2),
		    	'remark' => $remark,
		    	//'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $model->proddate])
		    ];
	    }

	    $data[] = [
	    	'name' => 'Line Efficiency',
	    	'color' => new JsExpression('Highcharts.getOptions().colors[3]'),
	    	//'colorByPoint' => true,
	    	'data' => $tmp_data
	    ];

	    $data_losstime[] = [
	    	'name' => 'Line Loss Time',
	    	'color' => new JsExpression('Highcharts.getOptions().colors[5]'),
	    	//'colorByPoint' => true,
	    	'data' => $tmp_data_losstime
	    ];

		return $this->render('index', [
			'data' => $data,
			'data_losstime' => $data_losstime,
			'model' => $model,
			'categories' => $categories
		]);
	}

	public function getLineArr()
	{
		$data_arr = DprLineEfficiencyView02::find()
		->select('DISTINCT(line)')
		->orderBy('line')
		->all();

		$return_arr = [];

		foreach ($data_arr as $key => $value) {
			$return_arr[] = $value->line;
		}

		return $return_arr;
	}

	public function getDprGmcEff($proddate, $line)
	{
		$eff_data_arr = DprLineEfficiencyView02::find()
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->all();

	    $return_arr = [];

	    foreach ($eff_data_arr as $key => $value) {
	    	$return_arr[$value->line] = $value->efficiency;
	    }

	    return $return_arr;
	}
}