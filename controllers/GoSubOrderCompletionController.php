<?php
namespace app\controllers;

use yii\web\Controller;
use dmstr\bootstrap\Tabs;
use yii\helpers\Url;
use app\models\GojekOrderView01;
use app\models\GojekTbl;
use app\models\GojekOrderTbl;
use yii\helpers\ArrayHelper;

class GoSubOrderCompletionController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }
    
	public function actionIndex()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data = [];
		$categories = [];

		$driver_arr = GojekTbl::find()
		->where([
			'SOURCE' => 'SUB'
		])
		->orderBy('HADIR DESC, GOJEK_DESC')
		->all();

		$tmp_data = [];

		foreach ($driver_arr as $value) {
			$nik = strval($value->GOJEK_ID);
			$order_data_arr = GojekOrderView01::find()
			->select([
				'GOJEK_ID',
				'GOJEK_DESC',
				'issued_date',
				'stat_open' => 'SUM(CASE WHEN STAT = \'O\' THEN 1 ELSE 0 END)',
				'stat_close' => 'SUM(CASE WHEN STAT = \'C\' THEN 1 ELSE 0 END)',
				'stat_total' => 'COUNT(STAT)'
			])
			->where([
				'GOJEK_ID' => $nik,
			])
			->andWhere(['>=', 'issued_date', date('Y-m-d', strtotime(date('Y-m-d') . '-10 days'))])
			->groupBy('GOJEK_ID, GOJEK_DESC, issued_date')
			->orderBy('GOJEK_DESC, issued_date')
			->asArray()
			->all();

			$total_point = 0;
			if (count($order_data_arr) > 0) {
				foreach ($order_data_arr as $order_data) {
					if ($order_data['issued_date'] == date('Y-m-d') && $nik == $order_data['GOJEK_ID']) {
						$total_point = $order_data['stat_close'];
					}
					$issued_date = (strtotime($order_data['issued_date'] . " +7 hours") * 1000);
					$tmp_data[$nik]['open'][] = [
						'x' => $issued_date,
						'y' => $order_data['stat_open'] == 0 ? null : (int)$order_data['stat_open'],
						'url' => Url::to(['get-remark', 'ISSUED_DATE' => $order_data['issued_date'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'O']),
					];
					$tmp_data[$nik]['close'][] = [
						'x' => $issued_date,
						'y' => $order_data['stat_close'] == 0 ? null : (int)$order_data['stat_close'],
						'url' => Url::to(['get-remark', 'ISSUED_DATE' => $order_data['issued_date'], 'GOJEK_ID' => $order_data['GOJEK_ID'], 'GOJEK_DESC' => $order_data['GOJEK_DESC'], 'STAT' => 'C']),
					];
					$tmp_data[$nik]['nama'] = $order_data['GOJEK_DESC'];
				}
			} else {
				$tmp_data[$nik]['open'] = null;
				$tmp_data[$nik]['close'] = null;
				$tmp_data[$nik]['nama'] = $value->GOJEK_DESC;
			}
			$tmp_data[$nik]['last_stage'] = $value->STAGE;
			$tmp_data[$nik]['from_loc'] = $value->from_loc;
			$tmp_data[$nik]['to_loc'] = $value->to_loc;
			$tmp_data[$nik]['last_update'] = $value->LAST_UPDATE;
			$tmp_data[$nik]['hadir'] = $value->HADIR;
			$tmp_data[$nik]['todays_point'] = $total_point;
			//$tmp_data[$nik]['item_desc'] = $value->item_desc;
		}

		$fix_data = [];
		foreach ($tmp_data as $key => $value) {
			$fix_data[$key]['data'] = [
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
			$fix_data[$key]['nama'] = $value['nama'];
			$fix_data[$key]['last_stage'] = $value['last_stage'];
			$fix_data[$key]['from_loc'] = $value['from_loc'];
			$fix_data[$key]['to_loc'] = $value['to_loc'];
			$fix_data[$key]['last_update'] = $value['last_update'];
			$fix_data[$key]['hadir'] = $value['hadir'];
			//$fix_data[$key]['item_desc'] = $value['item_desc'];
			//$fix_data[$key]['todays_point'] = isset($driver_point_arr[$key]) ? $driver_point_arr[$key] : 0;
			$fix_data[$key]['todays_point'] =  $value['todays_point'];
		}

		return $this->render('index', [
			//'data' => $data,
			'categories' => $categories,
			'max_order' => $max_order,
			'tmp_data' => $tmp_data,
			'fix_data' => $fix_data,
		]);
	}

	public function actionGetRemark($ISSUED_DATE, $GOJEK_ID, $GOJEK_DESC, $STAT)
	{
		$data_arr = GojekOrderTbl::find()
		->where([
			'GOJEK_ID' => $GOJEK_ID,
			'STAT' => $STAT,
			'FORMAT(issued_date, \'yyyy-MM-dd\')' => $ISSUED_DATE
		])
		->orderBy('issued_date DESC')
		->all();

		if ($STAT == 'O') {
			$status = 'OPEN';
		} else {
			$status = 'CLOSE';
		}

		$data = "<h4>Order List ($status) <small>$GOJEK_DESC</small></h4>";
		$data .= '<table class="table table-bordered table-hover table-striped">';
		$data .= 
		'<thead style="font-size: 14px;"><tr class="info">
            <th class="text-center">Slip No.</th>
            <th>Job Description</th>
            <th class="text-center">Departed</th>
            <th class="text-center">Arrived</th>
		</tr></thead>';
		$data .= '<tbody style="font-size: 14px;">';

		foreach ($data_arr as $key => $value) {
			$request_for = $value->request_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->request_date));
			$issued = $value->issued_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->issued_date));
			$departed = $value->daparture_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->daparture_date));
			$arrived = $value->arrival_date == null ? '-' : date('Y-m-d H:i:s', strtotime($value->arrival_date));
			$row_class = '';
			$qty = $value->quantity;
			if ($value->quantity_original !== null) {
				$row_class = 'danger';
				$qty = $value->quantity . ' of ' . $value->quantity_original;
			}
			$data .= '
				<tr class="' . $row_class . '">
					<td class="text-center">' . $value->slip_id . '</td>
                    <td>' . $value->item_desc . '</td>
                    <td class="text-center" style="min-width: 65px;">' . $departed . '</td>
                    <td class="text-center" style="min-width: 65px;">' . $arrived . '</td>
				</tr>
			';
		}

		$data .= '</tbody>';
		$data .= '</table>';

		return $data;
	}
}