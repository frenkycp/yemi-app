<?php

namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\models\PalletPointView;
use app\models\SernoSlipLog;
use app\models\PalletDriver;

class PalletOrderCompletionController extends Controller
{

	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

	public function actionIndex()
	{
		$driver_arr_data = User::find()
		->where([
			'role_id' => [19, 20]
		])
		->orderBy('role_id, name')
		->all();

		$tmp_data = [];
		foreach ($driver_arr_data as $key => $value) {
			$nik = $value->username;
			$data_arr = PalletPointView::find()->where([
				'nik' => $nik
			])
			->orderBy('order_date ASC')
			->all();

			$total_point = 0;

			if (count($data_arr) > 0) {
				foreach ($data_arr as $key2 => $value2) {
					$order_date = (strtotime($value2->order_date . " +7 hours") * 1000);
					$tmp_data[$nik]['open'][] = [
						'x' => $order_date,
						'y' => $value2->total_open == 0 ? null : (int)$value2->total_open,
						'url' => Url::to(['get-remark', 'order_date' => $value2->order_date, 'nik' => $nik, 'status' => 'OPEN']),
					];
					$tmp_data[$nik]['close'][] = [
						'x' => $order_date,
						'y' => $value2->total_close == 0 ? null : (int)$value2->total_close,
						'url' => Url::to(['get-remark', 'order_date' => $value2->order_date, 'nik' => $nik, 'status' => 'CLOSE']),
					];
					$tmp_data[$nik]['nama'] = $value->name;
					if($value2->order_date == date('Y-m-d')){
						$total_point = $value2->total_close;
					}
				}
			} else {
				$tmp_data[$nik]['open'] = null;
				$tmp_data[$nik]['close'] = null;
				$tmp_data[$nik]['nama'] = $value->name;
			}
			$tmp_data[$nik]['todays_point'] = $total_point;

			if ($value->role_id == 19) {
				$tmp_data[$nik]['factory'] = 1;
			} elseif ($value->role_id == 20) {
				$tmp_data[$nik]['factory'] = 2;
			}
		}

		$data = [];
		foreach ($tmp_data as $key => $value) {
			$pallet_driver = PalletDriver::find()
			->where([
				'nik' => $key
			])
			->one();

			$data[$key]['driver_status'] = 0;
			if ($pallet_driver != null) {
				$data[$key]['driver_status'] = $pallet_driver->driver_status;
				$data[$key]['order_from'] = $pallet_driver->order_from;
				$data[$key]['last_update'] = $pallet_driver->last_update;
			}

			$data[$key]['data'] = [
				[
					'name' => 'OPEN',
					'data' => $value['open'],
					'color' => 'rgba(255, 0, 0, 0.6)'
				],
				[
					'name' => 'CLOSE',
					'data' => $value['close'],
					'color' => 'rgba(0, 255, 0, 0.6)'
				]
			];
			$data[$key]['nama'] = $value['nama'];
			$data[$key]['todays_point'] = $value['todays_point'];
			$data[$key]['factory'] = $value['factory'];
		}

		return $this->render('index', [
			'data' => $data,
		]);
	}

	public function actionGetRemark($order_date, $nik, $status)
	{
		if ($status == 'OPEN') {
			$data_arr = SernoSlipLog::find()
			->where([
				'date(pk)' => $order_date,
				'nik' => $nik
			])
			->andWhere('arrival_time IS NULL')
			->all();
		} else {
			$data_arr = SernoSlipLog::find()
			->where([
				'date(pk)' => $order_date,
				'nik' => $nik
			])
			->andWhere('arrival_time IS NOT NULL')
			->all();
		}
		

		$data = "<h4>Order List ($status) <small>$nik</small></h4>";
		$data .= '<table class="table table-bordered table-hover">';
		$data .= 
		'<thead style="font-size: 12px;"><tr class="info">
            <th class="text-center">Line</th>
            <th class="text-center">Order Time</th>
            <th class="text-center">Pick Time</th>
            <th class="text-center">Arrival Time</th>
		</tr></thead>';
		$data .= '<tbody style="font-size: 10px;">';

		foreach ($data_arr as $key => $value) {
			$data .= '
				<tr>
					<td class="text-center">' . $value->line . '</td>
					<td class="text-center">' . $value->pk . '</td>
					<td class="text-center">' . $value->departure_datetime . '</td>
					<td class="text-center">' . $value->arrival_datetime . '</td>
				</tr>
			';
		}

		$data .= '</tbody>';
		$data .= '</table>';

		return $data;
	}
}