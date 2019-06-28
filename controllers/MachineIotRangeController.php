<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\MachineIotCurrentEffLog;

class MachineIotRangeController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');

		$model = new \yii\base\DynamicModel([
	        'machine_id', 'start_date', 'end_date'
	    ]);
	    $model->addRule(['machine_id', 'start_date', 'end_date'], 'required');
	    $data = [];

	    if ($model->load($_GET)) {
	    	$start_date = $model->start_date;
	    	$end_date = $model->end_date;

	    	/*$iot_by_hours = MachineIotCurrentEffLog::find()
			->where([
				'mesin_id' => $model->machine_id,
			])
			->andWhere(['>=', 'posting_shift', $start_date])
			->andWhere(['<=', 'posting_shift', $end_date])
			->asArray()
			->all();

			foreach ($iot_by_hours as $key => $value) {
				$jam = str_pad($value['jam'], 2, '0', STR_PAD_LEFT);
				$his = $jam . ':00:00';
				$ymd_his = date('Y-m-d', strtotime($value['posting_date'])) . ' ' . $his;
				$proddate = (strtotime($ymd_his . " +7 hours") * 1000);
				$tmp_data[$value['mesin_id']][] = [
					'x' => $proddate,
					'y' => (int)$value['pct']
					//'y' => (int)$value['pct'] == 0 ? null : (int)$value['pct']
				];
			}

			$data = [];
			foreach ($tmp_data as $key => $value) {
				$data[] = [
					'name' => $key,
					'data' => $value,
					'lineWidth' => 1,
				];
			}*/

			$iot_by_hours = MachineIotCurrentEffLog::find()
			->select([
				'mesin_id', 'mesin_description', 'posting_shift',
				'hijau' => 'SUM(hijau)',
				'hijau_biru_kuning' => 'SUM(hijau_biru + kuning)',
			])
			->where([
				'mesin_id' => $model->machine_id,
			])
			->andWhere(['>=', 'posting_shift', $start_date])
			->andWhere(['<=', 'posting_shift', $end_date])
			->groupBy('mesin_id, mesin_description, posting_shift')
			->orderBy('posting_shift')
			->asArray()
			->all();

			$begin = new \DateTime(date('Y-m-d', strtotime($start_date)));
			$end   = new \DateTime(date('Y-m-t', strtotime($end_date)));

			for($i = $begin; $i <= $end; $i->modify('+1 day')){
				$tgl = $i->format("Y-m-d");
				$proddate = (strtotime($tgl . " +7 hours") * 1000);
				foreach ($model->machine_id as $key => $machine_id) {
					$pct = null;
					foreach ($iot_by_hours as $key => $value) {
						
						if ($value['mesin_id'] == $machine_id && date('Y-m-d', strtotime($value['posting_shift'])) == $tgl) {
							$pct = 0;
							if ($value['hijau_biru_kuning'] > 0) {
								$pct = round(($value['hijau'] / $value['hijau_biru_kuning']) * 100);
							}
							break;
						}
					}
					$tmp_data[$machine_id][] = [
						'x' => $proddate,
						'y' => $pct
						//'y' => (int)$value['pct'] == 0 ? null : (int)$value['pct']
					];
				}
			}

			/*foreach ($iot_by_hours as $key => $value) {
				$proddate = (strtotime($value->posting_shift . " +7 hours") * 1000);
				$pct = 0;
				if ($value->hijau_biru_kuning > 0) {
					$pct = round(($value->hijau / $value->hijau_biru_kuning) * 100);
				}
				$tmp_data[$value->mesin_id][] = [
					'x' => $proddate,
					'y' => $pct
					//'y' => (int)$value['pct'] == 0 ? null : (int)$value['pct']
				];
			}*/

			foreach ($tmp_data as $key => $value) {
				$data[] = [
					'name' => $key,
					'data' => $value,
					//'lineWidth' => 1,
				];
			}
	    }

		return $this->render('index', [
			'model' => $model,
			'data' => $data,
		]);
	}
}