<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\BookingShipTrackView;
use app\models\BookingShipTrack02;

class PartsJitWeeklyController extends Controller
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
    	$trans_method = 'DDS';

        $month_arr = [];

        for ($month = 1; $month <= 12; $month++) {
            $month_arr[date("m", mktime(0, 0, 0, $month, 10))] = date("F", mktime(0, 0, 0, $month, 10));
        }

        $period_model = new \yii\base\DynamicModel([
            'year', 'month'
        ]);

        $period_model->addRule(['year','month'], 'required')
        ->addRule(['year', 'month'], 'string');

        $period_model->month = date('m');
        $period_model->year = date('Y');

        if($period_model->load(\Yii::$app->request->get())){
            // do somenthing with model
            //return $this->redirect(['view']);
        }

        $period = $period_model->year . $period_model->month;

    	$global_condition = [
			'PERIOD' => $period,
    		'TRANS_MTHD' => $trans_method
		];

    	$week_arr = $this->getWeekArr($global_condition);
    	$today = new \DateTime(date('Y-m-d'));
		$this_week = $today->format("W");
        if (!in_array($this_week, $week_arr)) {
            $this_week = end($week_arr);
        }
    	
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

    	foreach ($week_arr as $week_no) {
    		$tmp_category = [];
    		$tmp_data = [];
    		$tmp_data_open = [];
            $tmp_data_open2 = [];
    		$tmp_data_close = [];
    		foreach ($booking_data_arr as $booking_data) {
    			if ($week_no == $booking_data->WEEK) {
    				$tmp_category[] = $booking_data->DATE;
    				$open_qty = (int)$booking_data->total_open;
                    $open_qty2 = (int)$booking_data->total_open2;
                    $close_qty = (int)$booking_data->total_close;
                    $order_qty = $open_qty + $close_qty;

    				$tmp_data_open[] = [
                        'y' => $open_qty == 0 ? null : $open_qty,
                        //'y' => $open_qty == 0 ? null : $open_qty,
                        'remark' => $this->getRemark('STAT_02 = \'O\' AND STAT_ID NOT IN (3, 4)', $booking_data->DATE, $trans_method, 0)
                    ];
                    $tmp_data_open2[] = [
                        'y' => $open_qty2 == 0 ? null : $open_qty2,
                        'remark' => $this->getRemark('STAT_02 = \'O\' AND STAT_ID IN (3, 4)', $booking_data->DATE, $trans_method, 0)
                    ];
                    $tmp_data_close[] = [
                        'y' => $close_qty == 0 ? null : $close_qty,
                        //'y' => $close_qty == 0 ? null : $close_qty,
                        'remark' => $this->getRemark('STAT_02 = \'C\'', $booking_data->DATE, $trans_method, 0)
                    ];
    			}
    		}
    		$data[$week_no][] = [
    			'category' => $tmp_category,
    			'data' => [
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

    public function getRemark($bo_status, $date, $trans_method, $stat_id)
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
    }

}