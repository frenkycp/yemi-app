<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\MachineIot;
use app\models\MachineIotUtility;
use app\models\MachineIotUtilityByHours02;

class MntKwhReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		$data = [];
		//$machine_id = 'MNT00211';
		$posting_date = date('Y-m-d');
		$categories = [];
		$color = [
			'PUTIH',//IDLE
			'HIJAU',//running
			'BIRU',//SETTING
			'KUNING',//SETTING
			'MERAH',//stop
		];

		$model = new \yii\base\DynamicModel([
	        'posting_date', 'machine_id'
	    ]);
	    $model->addRule(['posting_date','machine_id'], 'required');
	    $model->posting_date = $posting_date;

		if (\Yii::$app->request->get('posting_date') !== null) {
			$model->posting_date = \Yii::$app->request->get('posting_date');
		}

		if (\Yii::$app->request->get('machine_id') !== null) {
			$model->machine_id = \Yii::$app->request->get('machine_id');
		}

		$year = substr($posting_date, 0, 4);
		$month = substr($posting_date, 5, 2);

		/*$data_report = MachineIot::find()
		->select([
			'posting_date', 'mesin_id', 'jam_no',
			'start_kwh' => 'MIN(kwh)',
			'end_kwh' => 'MAX(kwh)',
		])
		->where([
			'FORMAT(posting_date, \'yyyy-MM-dd\')' => $posting_date,
			'mesin_id' => $machine_id,
		])
		->groupBy('posting_date, mesin_id, jam_no')
		->orderBy('jam_no')
		->asArray()
		->all();
		$data_report = [];*/

		if ($model->load($_GET)) {
			$iot_by_hours = MachineIotUtilityByHours02::find()
			->where([
				'posting_date' => $model->posting_date,
				'mesin_id' => $model->machine_id,
			])
			->all();

			$tmp_data_kwh = $tmp_data_max_kwh = [];
			$tmp_data_by_hours = [];
			for ($i=0; $i < 24; $i++) { 
				/*$kwh = 0;
				$max_kwh = 0;
				foreach ($data_report as $key => $value) {
					if ($i == $value['jam_no']) {
						$start_kwh = (int)$value['start_kwh'];
						$end_kwh = (int)$value['end_kwh'];
						$kwh = $end_kwh - $start_kwh;
						$max_kwh = $end_kwh;
						break;
					}
				}*/
				$total_putih = null;
				$total_biru = null;
				$total_hijau = null;
				$total_merah = null;
				$sisa_detik = null;
				foreach ($iot_by_hours as $key => $value) {
					if ($i == $value->jam_no) {
						$sisa_detik = 3600 - $value->total_detik;
						if ($sisa_detik < 0) {
							$sisa_detik = 0;
						}
						$total_putih = $value->total_detik_putih;
						$total_hijau = $value->total_detik_hijau;
						$total_biru = $value->total_detik_biru;
						$total_merah = $value->total_detik_merah;
					}
					
				}
				$categories[] = $i;
				/*$tmp_data_kwh[] = $kwh == 0 ? null : $kwh;
				$tmp_data_max_kwh[] = $max_kwh == 0 ? null : $max_kwh;*/
				$tmp_data_by_hours['putih'][] = $total_putih == 0 ? null : $total_putih;
				$tmp_data_by_hours['hijau'][] = $total_hijau == 0 ? null : $total_hijau;
				$tmp_data_by_hours['biru'][] = $total_biru == 0 ? null : $total_biru;
				$tmp_data_by_hours['merah'][] = $total_merah == 0 ? null : $total_merah;
				$tmp_data_by_hours['sisa'][] = $sisa_detik == 0 ? null : $sisa_detik;
			}

			/*$data = [
				[
					'name' => 'KWH Measured',
					'data' => $tmp_data_max_kwh,
					'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
					'yAxis' => 1,
					//'showInLegend' => false,
					'dataLabels' => [
						'enabled' => true,
						//'format' => '{y} KWh'
					],
				],
				[
					'name' => 'KWH Consumption',
					'data' => $tmp_data_kwh,
					'color' => new JsExpression('Highcharts.getOptions().colors[8]'),
					//'showInLegend' => false,
					'dataLabels' => [
						'enabled' => true,
						//'format' => '{y} KWh'
					],
				]
			];*/
			$data_iot_by_hours = [
				[
					'name' => 'UNKNOWN',
					'data' => $tmp_data_by_hours['sisa'],
					'color' => 'rgba(0, 0, 0, 0)',
					'dataLabels' => [
						'enabled' => false
					],
					'showInLegend' => false,
				],
				[
					'name' => 'IDLE',
					'data' => $tmp_data_by_hours['putih'],
					'color' => 'silver'
				],
				[
					'name' => 'STOP',
					'data' => $tmp_data_by_hours['merah'],
					'color' => 'red'
				],
				[
					'name' => 'SETTING',
					'data' => $tmp_data_by_hours['biru'],
					'color' => 'blue'
				],
				[
					'name' => 'RUNNING',
					'data' => $tmp_data_by_hours['hijau'],
					'color' => 'green',
				],
				
			];

			$machine_iot_util = MachineIotUtility::find()
			->where([
				'period' => date('Ym', strtotime($model->posting_date)),
				'mesin_id' => $model->machine_id,
			])
			->orderBy('posting_date')
			->asArray()
			->all();

			$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
			$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

			$tmp_data = [];
			for($i = $begin; $i <= $end; $i->modify('+1 day')){
				$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
				$total_menit = null;
				//foreach ($color as $key => $color_value) {
				$total_putih = null;
				$total_biru = null;
				$total_hijau = null;
				$total_merah = null;
				foreach ($machine_iot_util as $key => $value) {
					if (date('Y-m-d', strtotime($value['posting_date'])) == $i->format("Y-m-d") && $value['status_warna'] == 'PUTIH') {
						$total_putih += round((int)$value['total_detik'] / 60);
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_date'])) == $i->format("Y-m-d") && ($value['status_warna'] == 'BIRU' || $value['status_warna'] == 'KUNING')) {
						$total_biru += round((int)$value['total_detik'] / 60);
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_date'])) == $i->format("Y-m-d") && $value['status_warna'] == 'HIJAU') {
						$total_hijau += round((int)$value['total_detik'] / 60);
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_date'])) == $i->format("Y-m-d") && $value['status_warna'] == 'MERAH') {
						$total_merah += round((int)$value['total_detik'] / 60);
						//break;
					}
				}
				$total_menit += $total_putih + $total_biru + $total_hijau + $total_merah;
				$tmp_data['PUTIH'][] = [
					'x' => $proddate,
					'y' => $total_putih
				];
				$tmp_data['BIRU'][] = [
					'x' => $proddate,
					'y' => $total_biru
				];
				$tmp_data['HIJAU'][] = [
					'x' => $proddate,
					'y' => $total_hijau
				];
				$tmp_data['MERAH'][] = [
					'x' => $proddate,
					'y' => $total_merah
				];
				//}
				$sisa_menit = 1440 - $total_menit;
				if ($sisa_menit == 1440 || $sisa_menit <= 0) {
					$sisa_menit = null;
				}
				$tmp_data['sisa'][] = [
					'x' => $proddate,
					'y' => $sisa_menit
				];
			}

			$data_iot = [];
			$data_iot = [
				[
					'name' => 'UNKNOWN',
					'data' => $tmp_data['sisa'],
					'color' => 'rgba(0, 0, 0, 0)',
					'dataLabels' => [
						'enabled' => false
					],
					'showInLegend' => false,
				],
				[
					'name' => 'IDLE',
					'data' => $tmp_data['PUTIH'],
					'color' => 'silver'
				],
				[
					'name' => 'STOP',
					'data' => $tmp_data['MERAH'],
					'color' => 'red'
				],
				[
					'name' => 'SETTING',
					'data' => $tmp_data['BIRU'],
					'color' => 'blue'
				],
				[
					'name' => 'RUNNING',
					'data' => $tmp_data['HIJAU'],
					'color' => 'green',
				],
				
			];
		}

		

		return $this->render('index', [
			'model' => $model,
			'posting_date' => $posting_date,
			'machine_id' => $machine_id,
			'categories' => $categories,
			'data_iot' => $data_iot,
			'data_iot_by_hours' => $data_iot_by_hours,
		]);
	}
}