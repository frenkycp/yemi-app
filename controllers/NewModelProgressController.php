<?php
namespace app\controllers;

use yii\web\Controller;

use app\models\WipPlanActualReport;

class NewModelProgressController extends Controller
{
	public function actionIndex()
	{
		$model = new \yii\base\DynamicModel([
	        'gmc', 'daily_qty', 'year', 'month'
	    ]);
	    $model->addRule(['gmc', 'daily_qty', 'year', 'month'], 'required');

	    $model->month = date('m');
		$model->year = date('Y');
		$model->daily_qty = 1;

		$data = [];

	    if ($model->load($_GET)) {
	    	//print_r($model->gmc);
	    	$period = $model->year . $model->month;
	    	$data = WipPlanActualReport::find()
	    	->select([
	    		'parent', 'parent_desc',
	    		'total_plan' => 'SUM(summary_qty)',
	    		'total_actual' => 'SUM(CASE WHEN stage in (\'03-COMPLETED\', \'04-HAND OVER\') THEN summary_qty ELSE 0 END)',
	    	])
	    	->where([
	    		'parent' => $model->gmc,
	    		'child_analyst' => 'WF01',
	    		'period' => $period
	    	])
	    	->groupBy('parent, parent_desc')
	    	->asArray()
	    	->all();
	    }

		return $this->render('index', [
			'model' => $model,
			'data' => $data,
		]);
	}

	public function actionGetWipProgress($parent = 'VAE8830', $period = '201906')
	{
		$tmp_wip_arr = WipPlanActualReport::find()
		->select([
			'child_analyst', 'child_analyst_desc', 'child', 'child_desc',
			'total_plan' => 'SUM(summary_qty)',
    		'total_actual' => 'SUM(CASE WHEN stage in (\'03-COMPLETED\', \'04-HAND OVER\') THEN summary_qty ELSE 0 END)',
		])
		->where([
			'parent' => $parent,
			'period' => $period
		])
		->andWhere('child_analyst NOT IN (\'WF01\', \'WS01\', \'WM04\', \'WM01\') ')
		->groupBy('child_analyst, child_analyst_desc, child, child_desc')
		->orderBy('child_analyst_desc, child')
		->asArray()
		->all();

		$tmp_data = [];
		$tmp_location = '';
		foreach ($tmp_wip_arr as $key => $value) {
			$part_no = $value['child'];
			$desc = $value['child_desc'];
			$location = $value['child_analyst_desc'];
			$plan = $value['total_plan'];
			$actual = $value['total_actual'];
			$tmp_data[$value['child_analyst_desc']][] = [
				'part_no' => $part_no,
				'desc' => $desc,
				'plan' => $plan,
				'actual' => $actual
			];
		}

		$all_content = '';
		foreach ($tmp_data as $key => $value) {

			$content = '';
			foreach ($value as $key2 => $value2) {
				$css_minus = '';
				$minus = (int)$value2['actual'] - (int)$value2['plan'];
				if ($minus < 0) {
					$css_minus = 'text-red';
				}
				$content .= '<tr style="font-size: 16px;">
					<td class="text-center">' . $value2['part_no'] . '</td>
					<td>' . $value2['desc'] . '</td>
					<td class="text-center">' . $value2['plan'] . '</td>
					<td class="text-center">' . $value2['actual'] . '</td>
					<td class="text-center ' . $css_minus . '">' . $minus . '</td>
				</tr>';
			}
			$all_content .= '<div class="box box-primary box-solid">
				<div class="box-header">
					<h3 class="box-title">' . $key . '</h3>
			    </div>
			    <div class="box-body no-padding">
			    	<table class="table table-bordered table-striped" id="detail-tbl">
			    		<thead>
							<tr style="font-size: 16px;">
								<th class="text-center">Part Num.</th>
								<th>Description</th>
								<th class="text-center">Plan Qty</th>
								<th class="text-center">Act. Qty</th>
								<th class="text-center">Minus</th>
							</tr>
						</thead>
						<tbody>' . $content . '</tbody>
			    	</table>
			    </div>
			</div>';
		}
		return $all_content;
	}
}