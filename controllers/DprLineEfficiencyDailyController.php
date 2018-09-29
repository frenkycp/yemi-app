<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\DprLineEfficiencyView02;
use app\models\DprGmcEffView;
use yii\helpers\Url;

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
	    ->all();

	    $dpr_gmc = DprGmcEffView::find()
	    ->where([
	    	'proddate' => $model->proddate,
	    ])
	    ->orderBy('efficiency DESC')
	    ->all();

	    foreach ($categories as $key => $line) {
		    $eff = 0;
		    foreach ($eff_data_arr as $key2 => $value2) {
		    	if ($value2->line == $line) {
		    		$eff = $value2->efficiency;
		    	}
		    }

		    $remark = "<h4>LINE $line<small> ($model->proddate)</small></h4>";
		    $remark .= '<table class="table">';
		    $remark .= '<tr>
		    	<th class="text-center">GMC</th>
		    	<th>Description</th>
		    	<th class="text-center">Qty Time</th>
		    	<th class="text-center">MP TIme</th>
		    	<th class="text-center">Efficiency</th>
		    </tr>';

		    foreach ($dpr_gmc as $value) {
		    	if ($value->line == $line) {
		    		$remark .= '<tr>
			    		<td class="text-center">' . $value->gmc . '</td>
			    		<td>' . $value->description . '</td>
			    		<td class="text-center">' . $value->qty_time . '</td>
			    		<td class="text-center">' . $value->mp_time . '</td>
			    		<td class="text-center">' . $value->efficiency . '%</td>
			    	</tr>';
		    	}
		    }

		    $remark .= '</table>';

		    $tmp_data[] = [
		    	'y' => round($eff, 2),
		    	'remark' => $remark,
		    	'url' => Url::to(['dpr-gmc-eff-data/index', 'line' => $line, 'proddate' => $model->proddate])
		    ];
	    }

	    $data[] = [
	    	'name' => 'Line Efficiency',
	    	'colorByPoint' => true,
	    	'data' => $tmp_data
	    ];

		return $this->render('index', [
			'data' => $data,
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