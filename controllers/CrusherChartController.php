<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\CrusherTbl;
use yii\helpers\Url;

class CrusherChartController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
	public function actionIndex()
	{
		$data = [];
		$period = date('Ym');

		$model = new \yii\base\DynamicModel([
	        'start_date', 'end_date'
	    ]);
	    $model->addRule(['start_date', 'end_date'], 'required');

	    if ($model->load($_GET)) {
	    	$tmp_crusher = CrusherTbl::find()
			->select([
				'date', 'model',
				'consume' => 'SUM(consume)'
			])
			->where(['>=', 'date', $model->start_date])
			->andWhere(['<=', 'date', $model->end_date])
			->groupBy('date, model')
			->all();

			$tmp_data = [];
			foreach ($tmp_crusher as $key => $value) {
				$proddate = (strtotime($value->date . " +7 hours") * 1000);
				$tmp_data[$value->model][] = [
					'x' => $proddate,
					'y' => round($value->consume, 1),
					'url' => Url::to(['get-remark', 'input_date' => $value->date, 'model' => $value->model]),
				];
			}

			foreach ($tmp_data as $key => $value) {
				$data[] = [
					'name' => $key,
					'data' => $value,
				];
			}
	    }

		return $this->render('index', [
			'data' => $data,
			'model' => $model,
		]);
	}
	
	public function actionGetRemark($input_date, $model)
	{
		$tmp_crusher = CrusherTbl::find()
		->where([
			'date' => $input_date,
			'model' => $model
		])
		->all();
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $model . ' <small>(' . $input_date . ')</small></h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 16px;">
	    	<th class="text-center">No.</th>
	    	<th class="text-center">Part</th>
	    	<th class="text-center">Qty</th>
	    	<th class="text-center">BOM</th>
	    	<th class="text-center">Consume (Kg)</th>
	    </tr>';

	    $no = 1;
	    foreach ($tmp_crusher as $key => $value) {
	    	$remark .= '<tr style="font-size: 16px;">
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value->part . '</td>
	    		<td class="text-center">' . $value->qty . '</td>
	    		<td class="text-center">' . $value->bom . '</td>
	    		<td class="text-center">' . $value->consume . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}