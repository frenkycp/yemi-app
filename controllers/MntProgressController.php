<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\MesinCheckNg;
use yii\helpers\Url;
use app\models\MesinCheckNgDtr;

class MntProgressController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$current_month = date('Y-m');
		/*$tmp_data = MesinCheckNg::find()
		->where(['like', 'CONVERT(VARCHAR(10),mesin_last_update,120)', $current_month])
		->andWhere(['repair_status' => 'O'])
		->orderBy('mesin_nama ASC')->all();*/
		$tmp_data = MesinCheckNg::find()
		->where(['repair_status' => 'O'])
		->orderBy('mesin_nama ASC')->all();
		$data_categories = [];
		$data_date = [];
		$title = date('F Y');
		$subtitle = '';
		$value_suffix = ' ' . date('F Y');

		foreach ($tmp_data as $value) {
			$data_categories[] = $value->mesin_nama . ' (' . $value->urutan . ')';
			$start_date = date('j', strtotime($value->mesin_last_update));
			if ((int)date('n', strtotime($value->mesin_last_update)) < (int)date('n')) {
				$start_date = 0;
			}
			
			$end_date = date('j');
			if ($value->repair_aktual != null) {
				$end_date = date('j', strtotime($value->repair_aktual));
			}

			if ($value->color_stat == 1) {
				$color = 'rgba(255, 153, 0, 0.8)';
			}else {
				$color = 'rgba(255, 0, 0, 0.8)';
			}

			$repair_plan = $value->repair_plan == null ? '-' : date('d M Y', strtotime($value->repair_plan));
			
			$remark = '
			<div class="row">
				<div class="col-md-3"><b>Machine Name</b></div>
				<div class="col-md-9">: ' . $value->mesin_nama . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Last Update</b></div>
				<div class="col-md-9">: ' . date('d M Y', strtotime($value->mesin_last_update)) . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Repair Plan</b></div>
				<div class="col-md-9">: ' . $repair_plan . '</div>
			</div>
			<hr/>
			<div class="row">
				<div class="col-md-3"><b>Remark</b></div>
				<div class="col-md-9">: ' . $value->mesin_catatan . '</div>
			</div>
			<hr/>
			';

			$remark .= $this->getDetailHdr($value->urutan);
			
			$data_date[] = [
				'low' => (int)$start_date,
				'high' => (int)$end_date,
				'color' => $color,
				'url' => Url::to(['/mesin-check-ng/index', 'ticket_no' => $value->urutan]),
				'remark' => $remark
			];
		}
		return $this->render('index', [
			'data_categories' => $data_categories,
			'data_date' => $data_date,
			'title' => $title,
			'subtitle' => $subtitle,
			'value_suffix' => $value_suffix
		]);
	}

	public function getDetailHdr($urutan)
	{
		$detail_arr = MesinCheckNgDtr::find()
		->where([
			'urutan' => $urutan
		])
		->orderBy('stat_last_update ASC')
		->all();

		$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr class="info">
			<th class="text-center">No</th>
			<th class="text-center">Last Update</th>
			<th class="text-center">Status</th>
		</tr>'
		;

		if (count($detail_arr) > 0) {
			$i = 1;
			foreach ($detail_arr as $value) {

				if ($value->color_stat == 1) {
					$status = 'Masih Dioperasikan';
					$row_class = 'warning';
				} else {
					$status = 'Stop';
					$row_class = 'danger';
				}
				$data .= '
					<tr class="' . $row_class . '">
						<td class="text-center">' . $i . '</td>
						<td class="text-center">' . date('Y-m-d H:i:s', strtotime($value->stat_last_update)) . '</td>
						<td class="text-center">' . $status . '</td>
					</tr>
				';
				$i++;
			}
		} else {
			$data .= '
				<tr class="' . $row_class . '">
					<td colspan=3>There is no detail data.</td>
				</tr>
			';
		}

		

		$data .= '</table>';

		return $data;
	}
}