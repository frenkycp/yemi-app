<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\MachineKwhReport;
use app\models\MachineIotUtility;

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
		$machine_id = 'MNT00211';
		$posting_date = date('Y-m-d');
		$categories = [];
		$color = [
			'PUTIH',//standby
			'HIJAU',//running
			'BIRU',//setting
			'MERAH',//stop
		];

		if (\Yii::$app->request->get('posting_date') !== null) {
			$posting_date = \Yii::$app->request->get('posting_date');
		}

		if (\Yii::$app->request->get('machine_id') !== null) {
			$machine_id = \Yii::$app->request->get('machine_id');
		}

		$year = substr($posting_date, 0, 4);
		$month = substr($posting_date, 5, 2);

		$data_report = MachineKwhReport::find()
		->where([
			'posting_date' => $posting_date,
			'mesin_id' => $machine_id,
		])
		->all();

		$tmp_data = [];
		for ($i=1; $i <= 24; $i++) { 
			$kwh = null;
			foreach ($data_report as $key => $value) {
				if ($i == $value->jam_no) {
					$kwh = (int)$value->power_consumption;
				}
			}
			$categories[] = $i;
			$tmp_data[] = $kwh;
		}

		$data[] = [
			'name' => 'Working Hour',
			'data' => $tmp_data,
			'showInLegend' => false,
			'dataLabels' => [
				'enabled' => true,
				'format' => '{y} KWh'
			],
		];

		$machine_iot_util = MachineIotUtility::find()
		->where([
			'period' => date('Ym', strtotime($posting_date)),
			'mesin_id' => $machine_id,
		])
		->orderBy('posting_date')
		->asArray()
		->all();

		$begin = new \DateTime(date('Y-m-d', strtotime($year . '-' . $month . '-01')));
		$end   = new \DateTime(date('Y-m-t', strtotime($year . '-' . $month . '-01')));

		$tmp_data = [];
		for($i = $begin; $i <= $end; $i->modify('+1 day')){
			$proddate = (strtotime($i->format("Y-m-d") . " +7 hours") * 1000);
			foreach ($color as $key => $color_value) {
				$menit = null;
				foreach ($machine_iot_util as $key => $value) {
					if (date('Y-m-d', strtotime($value['posting_date'])) == $i->format("Y-m-d") && $value['status_warna'] == $color_value) {
						$menit = round((int)$value['total_detik'] / 60);
						break;
					}
				}
				$tmp_data[$color_value][] = [
					'x' => $proddate,
					'y' => $menit
				];
			}
		}

		$data_iot = [];
		foreach ($tmp_data as $key => $value) {
			$color = 'dark gray';
			$legend_name = '';
			if ($key == 'MERAH') {
				$color = 'red';
				$legend_name = 'STOP';
			} elseif ($key == 'HIJAU') {
				$color = 'green';
				$legend_name = 'RUNNING';
			} elseif ($key == 'BIRU') {
				$color = 'blue';
				$legend_name = 'SETTING';
			} elseif ($key == 'PUTIH') {
				$color = 'white';
				$legend_name = 'STANDBY';
			}
			$data_iot[] = [
				'name' => $legend_name,
				'data' => $value,
				//'showInLegend' => false,
				'color' => $color
			];
		}

		return $this->render('index', [
			'data' => $data,
			'posting_date' => $posting_date,
			'machine_id' => $machine_id,
			'categories' => $categories,
			'data_iot' => $data_iot
		]);
	}
}