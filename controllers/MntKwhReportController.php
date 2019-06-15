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
use app\models\MachineIotCurrentEffLog;

class MntKwhReportController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		ini_set('max_execution_time', 300);
		date_default_timezone_set('Asia/Jakarta');
		
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

		if ($model->load($_GET) || \Yii::$app->request->get('posting_date') !== null) {
			$iot_by_hours = MachineIotCurrentEffLog::find()
			->where([
				'posting_shift' => $model->posting_date,
				'mesin_id' => $model->machine_id,
			])
			->asArray()
			->all();

			$tmp_data_by_hours = [];
			$start_hour = 7;
			for ($i=1; $i <= 24; $i++) {
				$seq = str_pad($i, 2, '0', STR_PAD_LEFT);
				$total_putih = null;
				$total_biru = null;
				$total_hijau = null;
				$total_merah = null;
				$sisa_detik = null;
				if ($start_hour == 24) {
					$start_hour = 0;
				}
				foreach ($iot_by_hours as $key => $value) {
					if ($seq == $value['seq']) {
						$sisa_detik = $value['lost_data'];
						$total_putih = $value['putih'];
						$total_hijau = $value['hijau'];
						$total_biru = $value['biru'] + $value['kuning'];
						$total_merah = $value['merah'];
					}
				}
				$categories[] = $start_hour;
				$tmp_data_by_hours['putih'][] = round($total_putih / 60, 1) == 0 ? null : round($total_putih / 60, 1);
				$tmp_data_by_hours['hijau'][] = round($total_hijau / 60, 1) == 0 ? null : round($total_hijau / 60, 1);
				$tmp_data_by_hours['biru'][] = round($total_biru / 60, 1) == 0 ? null : round($total_biru / 60, 1);
				$tmp_data_by_hours['merah'][] = round($total_merah / 60, 1) == 0 ? null : round($total_merah / 60, 1);
				$tmp_data_by_hours['sisa'][] = round($sisa_detik / 60, 1) == 0 ? null : round($sisa_detik / 60, 1);
				$start_hour++;
			}

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

			$machine_iot_util = MachineIotCurrentEffLog::find()
			->select([
				'posting_shift',
				'merah' => 'SUM(merah)',
				'kuning' => 'SUM(kuning)',
				'hijau' => 'SUM(hijau)',
				'biru' => 'SUM(biru)',
				'putih' => 'SUM(putih)',
				'lost_data' => 'SUM(lost_data)'
			])
			->where([
				'period_shift' => date('Ym', strtotime($model->posting_date)),
				'mesin_id' => $model->machine_id,
			])
			->groupBy('posting_shift')
			->asArray()
			->all();

			$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
			$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

			$start_date = (strtotime($begin->format('Y-m-d') . " +7 hours") * 1000);
			$end_date = (strtotime($end->format('Y-m-d') . " +7 hours") * 1000);

			$tmp_data = [];
			foreach ($machine_iot_util as $key => $value) {
				$proddate = (strtotime($value['posting_shift'] . " +7 hours") * 1000);
				$total_putih = round($value['putih'] / 60, 1);
				$total_biru = round(($value['biru'] + $value['kuning']) / 60, 1);
				$total_hijau = round($value['hijau'] / 60, 1);
				$total_merah = round($value['merah'] / 60, 1);
				$total_sisa = round($value['lost_data'] / 60, 1);

				$tmp_data['PUTIH'][] = [
					'x' => $proddate,
					'y' => $total_putih == 0 ? null : $total_putih
				];
				$tmp_data['BIRU'][] = [
					'x' => $proddate,
					'y' => $total_biru == 0 ? null : $total_biru
				];
				$tmp_data['HIJAU'][] = [
					'x' => $proddate,
					'y' => $total_hijau == 0 ? null : $total_hijau
				];
				$tmp_data['MERAH'][] = [
					'x' => $proddate,
					'y' => $total_merah == 0 ? null : $total_merah
				];
				$tmp_data['sisa'][] = [
					'x' => $proddate,
					'y' => $total_sisa == 0 ? null : $total_sisa
				];
			}
			/*for($i = $begin; $i <= $end; $i->modify('+1 day')){
				$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
				$total_menit = null;
				//foreach ($color as $key => $color_value) {
				$total_putih = null;
				$total_biru = null;
				$total_hijau = null;
				$total_merah = null;
				foreach ($machine_iot_util as $key => $value) {
					if (date('Y-m-d', strtotime($value['posting_shift']))) {
						$total_putih += round((int)$value['total_detik'] / 60);
						$total_biru += round((int)$value['total_detik'] / 60);
						$total_hijau += round((int)$value['total_detik'] / 60);
						$total_merah += round((int)$value['total_detik'] / 60);
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_shift'])) == $i->format("Y-m-d") && ($value['status_warna'] == 'BIRU' || $value['status_warna'] == 'KUNING')) {
						
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_shift'])) == $i->format("Y-m-d") && $value['status_warna'] == 'HIJAU') {
						
						//break;
					}
					if (date('Y-m-d', strtotime($value['posting_shift'])) == $i->format("Y-m-d") && $value['status_warna'] == 'MERAH') {
						
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
			}*/

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
			'start_date' => $start_date,
			'end_date' => $end_date,
		]);
	}
}