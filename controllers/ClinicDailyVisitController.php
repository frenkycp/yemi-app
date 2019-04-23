<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Url;
use app\models\ClinicDailyVisit;
use app\models\KlinikInput;

class ClinicDailyVisitController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$year = date('Y');
		$month = date('m');

		if (\Yii::$app->request->get('year') != null) {
            $year = \Yii::$app->request->get('year');
        }

        if (\Yii::$app->request->get('month') != null) {
            $month = \Yii::$app->request->get('month');
        }

        $period = $year . $month;

		$daily_visit = ClinicDailyVisit::find()
		->where([
			'period' => $period
		])
		->all();

		$tmp_data = [];
		foreach ($daily_visit as $key => $value) {
			$proddate = (strtotime($value->input_date . " +7 hours") * 1000);
			$tmp_data[] = [
				'x' => $proddate,
				'y' => (int)$value->total_visitor,
				'url' => Url::to(['get-remark', 'input_date' => $value->input_date]),
			];
		}

		$data[] = [
			'name' => 'Total Visitor',
			'data' => $tmp_data,
			'showInLegend' => false
		];

		return $this->render('index', [
			'data' => $data,
			'year' => $year,
			'month' => $month,
		]);
	}

	public function actionGetRemark($input_date)
	{
		$remark = '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>' . $input_date . '</h3>
		</div>
		<div class="modal-body">
		';
		
	    $remark .= '<table class="table table-bordered table-striped table-hover">';
	    $remark .= '<tr style="font-size: 12px;">
	    	<th>No.</th>
	    	<th class="text-center">NIK</th>
	    	<th>Nama</th>
	    	<th>Departemen</th>
	    	<th class="text-center">Keperluan</th>
	    	<th class="text-center">Masuk</th>
	    	<th class="text-center">Keluar</th>
	    	<th class="text-center">Diagnosa</th>
	    </tr>';

	    $data_arr = KlinikInput::find()
	    ->where([
	    	'date(pk)' => $input_date,
	    	'opsi' => [1, 2],
	    ])
	    ->orderBy('masuk')
	    ->all();

	    $no = 1;
	    foreach ($data_arr as $key => $value) {
	    	if ($value->opsi == 1) {
	    		$keperluan = 'PERIKSA';
	    	} elseif ($value->opsi == 2) {
	    		$keperluan = 'ISTIRAHAT SAKIT';
	    	} else {
	    		$keperluan = 'LAKSTASI';
	    	}
	    	$remark .= '<tr style="font-size: 12px;">
	    		<td class="text-center">' . $no . '</td>
	    		<td class="text-center">' . $value->nik . '</td>
	    		<td>' . $value->nama . '</td>
	    		<td>' . $value->dept . '</td>
	    		<td class="text-center">' . $keperluan . '</td>
	    		<td class="text-center">' . $value->masuk . '</td>
	    		<td class="text-center">' . $value->keluar . '</td>
	    		<td class="text-center">' . $value->diagnosa . '</td>
	    	</tr>';
	    	$no++;
	    }

	    $remark .= '</table>';
	    $remark .= '</div>';

	    return $remark;
	}
}