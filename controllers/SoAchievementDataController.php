<?php

namespace app\controllers;

use app\models\SernoOutput;

class SoAchievementDataController extends \app\controllers\base\SoAchievementDataController
{
	public function actionGetSoDetailData($period)
	{
		$so_data_arr = SernoOutput::find()
		->where([
			'id' => $period
		])
		->andWhere('DATE_FORMAT(etd, \'%Y%m\') > id')
		->orderBy('etd, gmc')
		->all();

		$data = "<h4>Delay List <small>" . date('F Y', strtotime($period . '01')) . "</small></h4>";
		$data .= '<table class="table table-bordered table-striped table-hover" style="font-size: 12px;">';
		$data .= 
		'<tr>
			<th class="text-center">GMC</th>
			<th>Description</th>
			<th>Port</th>
			<th class="text-center">Qty</th>
			<th class="text-center">ETD (Before)</th>
			<th class="text-center">ETD (After)</th>
			<th class="text-center">SO Num</th>
			<th>Remark</th>
		</tr>'
		;
		$no = 1;
		foreach ($so_data_arr as $value) {
			$data .= '
			<tr>
				<td class="text-center">' . $value->gmc . '</td>
				<td>' . $value->partName . '</td>
				<td>' . $value->dst . '</td>
				<td class="text-center">' . $value->qty . '</td>
				<td class="text-center">' . $value->etd_old . '</td>
				<td class="text-center">' . $value->etd . '</td>
				<td class="text-center">' . $value->so . '</td>
				<td class="text-yellow">' . $value->remark . '</td>
			</tr>
			';
			$no++;
		}
		
		$data .= '</table>';
		return $data;
	}
}
