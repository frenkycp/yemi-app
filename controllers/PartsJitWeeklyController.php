<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\BookingShipTrackView;
use app\models\BookingShipTrack02;

class PartsJitWeeklyController extends Controller
{
	/*public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }*/
    
    public function actionIndex()
    {
        date_default_timezone_set('Asia/Jakarta');
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$trans_method = 'DDS';

    	$global_condition = [
			'YEAR' => date('Y'),
    		'TRANS_MTHD' => $trans_method
		];

    	$week_arr = $this->getWeekArr($global_condition);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
        if (!in_array($this_week, $week_arr)) {
            $this_week = end($week_arr);
        }
    	
    	$booking_data_arr = BookingShipTrackView::find()
    	->where($global_condition)
    	->orderBy('WEEK ASC, DATE ASC')
    	->all();

    	foreach ($week_arr as $week_no) {
    		$tmp_category = [];
    		$tmp_data = [];
    		$tmp_data_open = [];
    		$tmp_data_close = [];
    		foreach ($booking_data_arr as $booking_data) {
    			if ($week_no == $booking_data->WEEK) {
    				$tmp_category[] = $booking_data->DATE;
    				$open_qty = $booking_data->BO_QTY;
    				$close_qty = $booking_data->RCV_QTY;
    				$order_qty = $booking_data->ORDER_QTY;

    				$open_percentage = 0;
    				$close_percentage = 0;
    				if ($order_qty > 0) {
    					$open_percentage = round((($open_qty / $order_qty) * 100), 2);
    					$close_percentage = round((($close_qty / $order_qty) * 100), 2);
    				}
    				$tmp_data_open[] = [
    					'y' => $open_percentage == 0 ? null : $open_percentage,
    					'remark' => $this->getRemark('BO_QTY > 0', $booking_data->DATE, $trans_method, $booking_data->STAT_ID)
    				];
    				$tmp_data_close[] = [
    					'y' => $close_percentage == 0 ? null : $close_percentage,
    					'remark' => $this->getRemark('BO_QTY = 0', $booking_data->DATE, $trans_method, $booking_data->STAT_ID)
    				];
    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
    			'data' => [
    				[
    					'name' => 'OUTSTANDING',
    					'data' => $tmp_data_open,
    					'color' => 'rgba(200, 200, 200, 0.4)',
    					'showInLegend' => false,
    				],
    				[
    					'name' => 'DEPARTURE',
    					'data' => $tmp_data_close,
    					'color' => 'rgba(0, 200, 0, 0.4)',
    					'showInLegend' => false,
    				],
    			]
    		];
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'data' => $data,
    		'this_week' => $this_week
    	]);
    }

    public function getWeekArr($global_condition)
    {
    	$return_arr = [];
    	$data_arr = BookingShipTrackView::find()
    	->select('WEEK')
    	->where($global_condition)
    	->groupBy('WEEK')
    	->orderBy('WEEK')
    	->all();

    	foreach ($data_arr as $value) {
    		$return_arr[] = $value->WEEK;
    	}

    	return $return_arr;
    }

    public function getRemark($bo_status, $date, $trans_method, $stat_id)
    {
    	$data_arr = BookingShipTrack02::find()
    	->where([
    		'TRANS_MTHD' => $trans_method,
    		'STAT_ID' => $stat_id
    	])
    	->andWhere($bo_status)
    	->andWhere(['like', 'CONVERT(VARCHAR(10),PICKUP_ACTUAL,120)', $date])
    	->orderBy('BOOKING_ID ASC')
    	->all();

    	$data = '<table class="table table-bordered table-striped table-hover">';
		$data .= 
		'<tr>
			<th class="text-center">Booking ID</th>
			<th>User Description</th>
			<th class="text-center">Pickup Actual</th>
			<th>Shipper</th>
			<th>PIC Description</th>
			<th class="text-center">Item</th>
			<th>Item Description</th>
			<th class="text-center">Order Qty</th>
			<th class="text-center">Rcv Qty</th>
			<th class="text-center">BO Qty</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
			$data .= '
				<tr>
					<td class="text-center">' . $value['BOOKING_ID'] . '</td>
					<td>' . $value['USER_DESC'] . '</td>
					<td class="text-center">' . $value['PICKUP_ACTUAL'] . '</td>
					<td>' . $value['SHIPPER'] . '</td>
					<td>' . $value['PIC_DESC'] . '</td>
					<td class="text-center">' . $value['ITEM'] . '</td>
					<td>' . $value['ITEM_DESC'] . '</td>
					<td class="text-center">' . $value['ORDER_QTY'] . '</td>
					<td class="text-center">' . $value['RCV_QTY'] . '</td>
					<td class="text-center">' . abs($value['BO_QTY']) . '</td>
				</tr>
				';
		}

		$data .= '</table>';
		return $data;
    }

}