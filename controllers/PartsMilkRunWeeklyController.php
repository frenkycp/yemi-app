<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\BookingShipTrackView;
use app\models\BookingShipTrack02;
use yii\web\JsExpression;

class PartsMilkRunWeeklyController extends Controller
{
	public function behaviors()
    {
        //apply role_action table for privilege (doesn't apply to super admin)
        return \app\models\Action::getAccess($this->id);
    }

    public function actionIndex()
    {
        date_default_timezone_set('Asia/Jakarta');
    	$title = '';
    	$subtitle = '';
    	$data = [];
    	$trans_method = 'MRS';

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        $period = $model->period;

    	$global_condition = [
    		'TRANS_MTHD' => $trans_method,
            'PERIOD' => $period
		];

        $booking_data_arr = BookingShipTrackView::find()
        ->select([
            'WEEK',
            'DATE',
            'total_open' => 'SUM(CASE WHEN STAT_02 = \'O\' AND STAT_ID NOT IN (3, 4) THEN ORDER_QTY ELSE 0 END)',
            'total_open2' => 'SUM(CASE WHEN STAT_02 = \'O\' AND STAT_ID IN (3, 4) THEN ORDER_QTY ELSE 0 END)',
            'total_close' => 'SUM(CASE WHEN STAT_02 = \'C\' THEN ORDER_QTY ELSE 0 END)'
        ])
        ->where($global_condition)
        ->groupBy('WEEK, DATE')
        ->orderBy('DATE ASC')
        ->all();

        $week_arr = [];
        foreach ($booking_data_arr as $key => $value) {
            if (!in_array($value->WEEK, $week_arr)) {
                $week_arr[] = $value->WEEK;
            }
        }

    	//$week_arr = $this->getWeekArr($global_condition);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
		if (!in_array($this_week, $week_arr)) {
			$this_week = end($week_arr);
		}

        $detail_data_arr = BookingShipTrack02::find()
        ->where([
            'TRANS_MTHD' => $trans_method,
            'PERIOD' => $period
        ])
        ->orderBy('BOOKING_ID ASC')
        ->all();

    	foreach ($week_arr as $week_no) {
    		$tmp_category = [];
    		$tmp_data = [];
    		$tmp_data_open = [];
            $tmp_data_open2 = [];
            $tmp_data_open3 = [];
    		$tmp_data_close = [];
    		foreach ($booking_data_arr as $booking_data) {
    			if ($week_no == $booking_data->WEEK) {
    				$tmp_category[] = $booking_data->DATE;
    				$open_qty = (int)$booking_data->total_open;
                    $open_qty2 = (int)$booking_data->total_open2;
                    $open_qty3 = (int)$booking_data->total_open + (int)$booking_data->total_open2;
    				$close_qty = (int)$booking_data->total_close;
    				$order_qty = $open_qty + $close_qty;
                    $datetime1 = new \DateTime(date('Y-m-d'));
                    $datetime2 = new \DateTime($booking_data->DATE);
                    $interval = $datetime1->diff($datetime2);

                    if ($interval->format('%a') > 7 && $datetime2 < $datetime1) {
                        $open_qty = $open_qty2 = 0;
                    } else {
                        $open_qty3 = 0;
                    }

    				$tmp_data_open[] = [
    					'y' => $open_qty == 0 ? null : $open_qty,
                        'remark' => $this->getRemark('O1', $booking_data->DATE, $detail_data_arr)
    					//'remark' => $this->getRemark('STAT_02 = \'O\' AND STAT_ID NOT IN (3, 4)', $booking_data->DATE, $trans_method, 0)
    				];
                    $tmp_data_open2[] = [
                        'y' => $open_qty2 == 0 ? null : $open_qty2,
                        'remark' => $this->getRemark('O2', $booking_data->DATE, $detail_data_arr)
                        //'remark' => $this->getRemark('STAT_02 = \'O\' AND STAT_ID IN (3, 4)', $booking_data->DATE, $trans_method, 0)
                    ];
                    $tmp_data_open3[] = [
                        'y' => $open_qty3 == 0 ? null : $open_qty3,
                        'remark' => $this->getRemark('O3', $booking_data->DATE, $detail_data_arr)
                        //'remark' => $this->getRemark('STAT_02 = \'O\'', $booking_data->DATE, $trans_method, 0)
                    ];
    				$tmp_data_close[] = [
    					'y' => $close_qty == 0 ? null : $close_qty,
    					'remark' => $this->getRemark('C', $booking_data->DATE, $detail_data_arr)
    					//'remark' => $this->getRemark('STAT_02 = \'C\'', $booking_data->DATE, $trans_method, 0)
    				];
    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
    			'data' => [
                    [
                        'name' => 'Cancel',
                        'data' => $tmp_data_open3,
                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
                        //'showInLegend' => false,
                    ],
    				[
    					'name' => 'Prepared',
    					'data' => $tmp_data_open,
    					'color' => 'rgba(200, 200, 200, 0.8)',
    					//'showInLegend' => false,
    				],
                    [
                        'name' => 'Partially Departed & Received',
                        'data' => $tmp_data_open2,
                        'color' => 'rgba(255, 200, 0, 0.8)',
                        //'showInLegend' => false,
                    ],
    				[
    					'name' => 'Fully Departed & Received',
    					'data' => $tmp_data_close,
    					'color' => 'rgba(0, 200, 0, 0.8)',
    					//'showInLegend' => false,
    				],
    			]
    		];
    	}

    	return $this->render('index', [
    		'title' => $title,
    		'subtitle' => $subtitle,
    		'data' => $data,
            'model' => $model,
    		'this_week' => $this_week,
            'period_model' => $period_model,
            'month_arr' => $month_arr
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

    public function getRemark($bo_status, $date, $detail_data_arr)
    {

        $data = '<table class="table table-bordered table-striped table-hover">';
        $data .= 
        '<tr>
            <th class="text-center">Booking ID</th>
            <th>User Description</th>
            <th class="text-center">Pickup Actual</th>
            <th class="text-center" style="width:80px;">YEMI Arrival</th>
            <th>Shipper</th>
            <th class="text-center">Item</th>
            <th>Item Description</th>
            <th class="text-center">Order Qty</th>
            <th class="text-center">Rcv Qty</th>
            <th class="text-center">BO Qty</th>
            <th>Status</th>
        </tr>'
        ;

        foreach ($detail_data_arr as $value) {
            if (date('Y-m-d', strtotime($value->PICKUP_ACTUAL)) == $date) {
                $tambahkan = false;
                if ($bo_status == 'O1') {
                    if ($value->STAT_02 == 'O' && !in_array($value->STAT_ID, [3, 4])) {
                        $tambahkan = true;
                    }
                } elseif ($bo_status == 'O2') {
                    if ($value->STAT_02 == 'O' && in_array($value->STAT_ID, [3, 4])) {
                        $tambahkan = true;
                    }
                } elseif ($bo_status == 'O3') {
                    if ($value->STAT_02 == 'O') {
                        $tambahkan = true;
                    }
                } elseif ($bo_status == 'C') {
                    if ($value->STAT_02 == 'C') {
                        $tambahkan = true;
                    }
                }

                if ($tambahkan) {
                    $yemi_arrival_date = $value->YEMI_ARRIVAL == null ? '-' : date('Y-m-d', strtotime($value->YEMI_ARRIVAL));
                    $pickup_actual = '-';
                    if (date('H:i:s', strtotime($value->PICKUP_ACTUAL)) != '00:00:00') {
                        $pickup_actual = $value->PICKUP_ACTUAL;
                    }
                    $data .= '
                    <tr>
                        <td class="text-center">' . $value->BOOKING_ID . '</td>
                        <td>' . $value->USER_DESC . '</td>
                        <td class="text-center">' . $pickup_actual . '</td>
                        <td class="text-center">' . $yemi_arrival_date . '</td>
                        <td>' . $value->SHIPPER . '</td>
                        <td class="text-center">' . $value['ITEM'] . '</td>
                        <td>' . $value->ITEM_DESC . '</td>
                        <td class="text-center">' . $value->ORDER_QTY . '</td>
                        <td class="text-center">' . $value->RCV_QTY . '</td>
                        <td class="text-center">' . abs($value->BO_QTY) . '</td>
                        <td class="text-center">' . $value->STAT_ID_DESC . '</td>
                    </tr>
                    ';
                }
                
            }
            
        }

        $data .= '</table>';
        return $data;
    }

    /*public function getRemark($bo_status, $date, $trans_method, $stat_id)
    {
    	$data_arr = BookingShipTrack02::find()
    	->where([
    		'TRANS_MTHD' => $trans_method,
    		//'STAT_ID' => $stat_id
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
            <th class="text-center" style="width:80px;">YEMI Arrival</th>
			<th>Shipper</th>
			<th class="text-center">Item</th>
			<th>Item Description</th>
			<th class="text-center">Order Qty</th>
			<th class="text-center">Rcv Qty</th>
			<th class="text-center">BO Qty</th>
            <th>Status</th>
		</tr>'
		;

		foreach ($data_arr as $value) {
            $yemi_arrival_date = $value['YEMI_ARRIVAL'] == null ? '-' : date('Y-m-d', strtotime($value['YEMI_ARRIVAL']));
            $pickup_actual = '-';
            if (date('H:i:s', strtotime($value['PICKUP_ACTUAL'])) != '00:00:00') {
                $pickup_actual = $value['PICKUP_ACTUAL'];
            }
			$data .= '
				<tr>
					<td class="text-center">' . $value['BOOKING_ID'] . '</td>
					<td>' . $value['USER_DESC'] . '</td>
					<td class="text-center">' . $pickup_actual . '</td>
                    <td class="text-center">' . $yemi_arrival_date . '</td>
					<td>' . $value['SHIPPER'] . '</td>
					<td class="text-center">' . $value['ITEM'] . '</td>
					<td>' . $value['ITEM_DESC'] . '</td>
					<td class="text-center">' . $value['ORDER_QTY'] . '</td>
					<td class="text-center">' . $value['RCV_QTY'] . '</td>
					<td class="text-center">' . abs($value['BO_QTY']) . '</td>
                    <td class="text-center">' . $value['STAT_ID_DESC'] . '</td>
				</tr>
				';
		}

		$data .= '</table>';
		return $data;
    }*/

}