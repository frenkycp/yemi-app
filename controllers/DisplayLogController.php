<?php
namespace app\controllers;

use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use dmstr\bootstrap\Tabs;
use app\models\SernoOutput;
use app\models\ShipReservationDtr;
use app\models\WorkDayTbl;
use app\models\ShipReservationView02;
use app\models\ShippingContainerView01;
use app\models\ContainerView;
use app\models\ShippingOrderView03;
use app\models\ShippingOrderNew01;
use app\models\GeneralFunction;
use app\models\ShippingModel;
/**
 * 
 */
class DisplayLogController extends Controller
{
    public function actionShippingOrderProgress($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');
        $today = date('Y-m-d');

        if ($model->load($_GET)) {

        }

        $tmp_data = ShippingOrderNew01::find()
        ->select([
            'TOTAL_CONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_CONFIRMED_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_YEMI' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ETD <= \'' . $today . '\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_YEMI_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ETD <= \'' . $today . '\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_SUB' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ON_BOARD_STATUS = 1 THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_SUB_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ON_BOARD_STATUS = 1 THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
        ])
        ->where([
            'PERIOD' => $model->period,
        ])
        ->groupBy('PERIOD')
        ->orderBy('TOTAL_UNCONFIRMED DESC')
        ->one();

        $data = [
            'plan' => $tmp_data->TOTAL_CONFIRMED + $tmp_data->TOTAL_UNCONFIRMED,
            'plan_teu' => $tmp_data->TOTAL_CONFIRMED_TEU + $tmp_data->TOTAL_UNCONFIRMED_TEU,
            'confirmed' => $tmp_data->TOTAL_CONFIRMED,
            'confirmed_teu' => $tmp_data->TOTAL_CONFIRMED_TEU,
            'unconfirmed' => $tmp_data->TOTAL_UNCONFIRMED,
            'unconfirmed_teu' => $tmp_data->TOTAL_UNCONFIRMED_TEU,
            'etd_sub' => $tmp_data->TOTAL_ETD_SUB,
            'etd_sub_teu' => $tmp_data->TOTAL_ETD_SUB_TEU,
            'at_port' => $tmp_data->TOTAL_ETD_YEMI - $tmp_data->TOTAL_ETD_SUB,
            'at_port_teu' => $tmp_data->TOTAL_ETD_YEMI_TEU - $tmp_data->TOTAL_ETD_SUB_TEU,
        ];
        $data_pct = [
            'confirmed' => $data['plan'] > 0 ? round(($data['confirmed'] / $data['plan']) * 100) : 0,
            'confirmed_teu' => $data['plan_teu'] > 0 ? round(($data['confirmed_teu'] / $data['plan_teu']) * 100) : 0,
            'etd_sub' => $data['plan'] > 0 ? round(($data['etd_sub'] / $data['plan']) * 100) : 0,
            'etd_sub_teu' => $data['plan_teu'] > 0 ? round(($data['etd_sub_teu'] / $data['plan_teu']) * 100) : 0,
            'at_port' => $data['plan'] > 0 ? round(($data['at_port'] / $data['plan']) * 100) : 0,
            'at_port_teu' => $data['plan_teu'] > 0 ? round(($data['at_port_teu'] / $data['plan_teu']) * 100) : 0,
        ];

        return $this->render('shipping-order-progress', [
            'data' => $data,
            'data_pct' => $data_pct,
            'model' => $model,
        ]);
    }

    public function actionShippingOrderNew($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        $period_name = strtoupper(date('M Y', strtotime($model->period . '01')));

        $tmp_shipping_order = ShippingOrderNew01::find()
        ->select([
            'ETD',
            'TOTAL_CONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ON_BOARD' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ON_BOARD_STATUS = 1 THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
        ])
        ->where([
            'PERIOD' => $model->period,
        ])
        ->groupBy('ETD')
        ->orderBy('ETD')
        ->all();

        $tmp_confirm = $tmp_unconfirm = $tmp_rejected = $tmp_on_board = [];
        $total_plan = $total_confirm = $total_reject = $total_unconfirm = $total_etd_yemi = $total_on_board = 0;
        foreach ($tmp_shipping_order as $order_value) {
            $post_date = (strtotime($order_value->ETD . " +7 hours") * 1000);

            $tmp_confirm[] = [
                'x' => $post_date,
                'y' => (int)$order_value->TOTAL_CONFIRMED == 0 ? null : (int)$order_value->TOTAL_CONFIRMED,
            ];

            $tmp_unconfirm[] = [
                'x' => $post_date,
                'y' => (int)$order_value->TOTAL_UNCONFIRMED == 0 ? null : (int)$order_value->TOTAL_UNCONFIRMED,
            ];

            $tmp_rejected[] = [
                'x' => $post_date,
                'y' => null,
            ];

            $tmp_on_board[] = [
                'x' => $post_date,
                'y' => (int)$order_value->TOTAL_ON_BOARD/* == 0 ? null : (int)$order_value->TOTAL_ON_BOARD*/,
            ];

            $total_confirm += $order_value->TOTAL_CONFIRMED;
            $total_unconfirm += $order_value->TOTAL_UNCONFIRMED;
            $total_on_board += $order_value->TOTAL_ON_BOARD;

            if ($order_value->ETD <= date('Y-m-d')) {
                $total_etd_yemi += $order_value->TOTAL_CONFIRMED;
            }
        }

        $total_plan = $total_confirm + $total_unconfirm;

        $data = [
            /*[
                'name' => 'REJECTED',
                'data' => $tmp_rejected,
                'color' => '#001F3F',
                'stack' => 'etd_yemi'
            ],*/
            [
                'name' => 'NOT CONFIRMED',
                'data' => $tmp_unconfirm,
                'color' => '#dd4b39',
                'stack' => 'etd_yemi'
            ],
            [
                'name' => 'CONFIRMED',
                'data' => $tmp_confirm,
                'color' => '#00a65a',
                'stack' => 'etd_yemi'
            ],
            [
                'name' => 'ETD PORT',
                'data' => $tmp_on_board,
                'color' => '#ff851b',
                'stack' => 'etd_port'
            ],
        ];

        $order_by_pod = ShippingOrderNew01::find()
        ->select([
            'POD',
            'TOTAL_CONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
        ])
        ->where([
            'PERIOD' => $model->period,
        ])
        ->groupBy('POD')
        ->orderBy('TOTAL_UNCONFIRMED DESC')
        ->all();

        $pct_arr = [
            'confirm' => 0,
            'reject' => 0,
            'unconfirm' => 0,
        ];

        if ($total_plan > 0) {
            $pct_arr['confirm'] = round(($total_confirm / $total_plan) * 100, 2);
            $pct_arr['reject'] = round(($total_reject / $total_plan) * 100, 2);
            $pct_arr['unconfirm'] = round(($total_unconfirm / $total_plan) * 100, 2);
            $pct_arr['etd_yemi'] = round(($total_etd_yemi / $total_plan) * 100, 2);
            $pct_arr['etd_port'] = round(($total_on_board / $total_plan) * 100, 2);
        }

        return $this->render('shipping-order-new', [
            'data' => $data,
            'model' => $model,
            'period_name' => $period_name,
            'tmp_shipping_order' => $tmp_shipping_order,
            'total_plan' => $total_plan,
            'total_confirm' => $total_confirm,
            'total_unconfirm' => $total_unconfirm,
            'total_reject' => $total_reject,
            'total_etd_yemi' => $total_etd_yemi,
            'total_on_board' => $total_on_board,
            'pct_arr' => $pct_arr,
            'order_by_pod' => $order_by_pod,
        ]);
    }

    public function actionShippingOrder($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'period'
        ]);
        $model->addRule(['period'], 'required');
        $model->period = date('Ym');

        if ($model->load($_GET)) {

        }

        $period_name = strtoupper(date('M Y', strtotime($model->period . '01')));

        $today = date('Y-m-d');

        $total_plan = $total_plan_teu = $total_confirm = $total_not_confirm = $total_confirm_teu = $total_not_confirm_teu = 0;
        $plan_pct = $confirm_pct = $not_confirm_pct = $confirm_pct_teu = $not_confirm_pct_teu = $ship_out_pct = $ship_out_pct_teu = 0;
        $data_arr = [];

        $order_by_pod = ShippingOrderNew01::find()
        ->select([
            'POD',
            'TOTAL_CONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_CONFIRMED_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_UNCONFIRMED_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING REQUESTED\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
        ])
        ->where([
            'PERIOD' => $model->period,
        ])
        ->groupBy('POD')
        ->orderBy('TOTAL_UNCONFIRMED DESC')
        ->all();

        foreach ($order_by_pod as $key => $value) {
            $total_plan += $value->TOTAL_CONFIRMED + $value->TOTAL_UNCONFIRMED;
            $total_plan_teu += $value->TOTAL_CONFIRMED_TEU + $value->TOTAL_UNCONFIRMED_TEU;
            $total_confirm += $value->TOTAL_CONFIRMED;
            $total_not_confirm += $value->TOTAL_UNCONFIRMED;
            $total_confirm_teu += $value->TOTAL_CONFIRMED_TEU;
            $total_not_confirm_teu += $value->TOTAL_UNCONFIRMED_TEU;

            $data_arr[$value->POD] = [
                'plan' => $value->TOTAL_CONFIRMED + $value->TOTAL_UNCONFIRMED,
                'confirm' => $value->TOTAL_CONFIRMED,
                'not_confirm' => $value->TOTAL_UNCONFIRMED
            ];
        }

        $total_etd_yemi = ShippingOrderNew01::find()
        ->select([
            'TOTAL_ETD_YEMI' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_YEMI_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_SUB' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ON_BOARD_STATUS = 1 THEN (CNT_40HC + CNT_40 + CNT_20 + LCL) ELSE 0 END)',
            'TOTAL_ETD_SUB_TEU' => 'SUM(CASE WHEN STATUS = \'BOOKING CONFIRMED\' AND ON_BOARD_STATUS = 1 THEN ((CNT_40HC * 2) + (CNT_40 * 2) + CNT_20 + LCL) ELSE 0 END)',
        ])
        ->where([
            'PERIOD' => $model->period,
        ])
        ->andWhere([
            '<=',
            'ETD',
            $today
        ])
        ->one();

        if ($total_plan > 0) {
            $plan_pct = 100;
            $confirm_pct = round($total_confirm / $total_plan * 100);
            $not_confirm_pct = round($total_not_confirm / $total_plan * 100);
        }
        if ($total_plan_teu > 0) {
            $confirm_pct_teu = round($total_confirm_teu / $total_plan_teu * 100);
            $not_confirm_pct_teu = round($total_not_confirm_teu / $total_plan_teu * 100);
        }
        
        if ($total_confirm > 0) {
            $ship_out_pct = round($total_etd_yemi->TOTAL_ETD_YEMI / $total_confirm * 100);
        }

        if ($total_confirm_teu > 0) {
            $ship_out_pct_teu = round($total_etd_yemi->TOTAL_ETD_YEMI_TEU / $total_confirm_teu * 100);
        }

        $data = [
            'total_plan' => $total_plan,
            'total_plan_teu' => $total_plan_teu,
            'total_confirm' => $total_confirm,
            'total_confirm_teu' => $total_confirm_teu,
            'total_not_confirm' => $total_not_confirm,
            'total_not_confirm_teu' => $total_not_confirm_teu,
            'confirm_pct' => $confirm_pct,
            'confirm_pct_teu' => $confirm_pct_teu,
            'not_confirm_pct' => $not_confirm_pct,
            'not_confirm_pct_teu' => $not_confirm_pct_teu,
            'total_etd_yemi' => $total_etd_yemi->TOTAL_ETD_YEMI,
            'total_etd_yemi_teu' => $total_etd_yemi->TOTAL_ETD_YEMI_TEU,
            'total_etd_sub' => $total_etd_yemi->TOTAL_ETD_SUB,
            'total_etd_sub_teu' => $total_etd_yemi->TOTAL_ETD_SUB_TEU,
            'total_at_port' => $total_etd_yemi->TOTAL_ETD_YEMI - $total_etd_yemi->TOTAL_ETD_SUB,
            'total_at_port_teu' => $total_etd_yemi->TOTAL_ETD_YEMI_TEU - $total_etd_yemi->TOTAL_ETD_SUB_TEU,
            'not_yet_stuffing' => $total_confirm - $total_etd_yemi->TOTAL_ETD_YEMI,
            'not_yet_stuffing_teu' => $total_confirm_teu - $total_etd_yemi->TOTAL_ETD_YEMI_TEU,
            'ship_out_pct' => $ship_out_pct,
            'ship_out_pct_teu' => $ship_out_pct_teu,
        ];

        return $this->render('shipping-order', [
            'data' => $data,
            'model' => $model,
            'period_name' => $period_name,
            'data_arr' => $data_arr,
            'plan_pct' => $plan_pct,
        ]);
    }

	public function actionShipReservationSummary($value='')
	{
		//$this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $model = new \yii\base\DynamicModel([
            'from_date', 'to_date'
        ]);
        $model->addRule(['from_date', 'to_date'], 'required');

        $model->from_date = date('Y-m-01');
        $model->to_date = date('Y-m-t');

        if ($model->load($_GET)) {

        }

        $tmp_reservation_summary = ShipReservationDtr::find()
        ->select([
        	'main_40hc' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'sub_40hc' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'backup_40hc' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_40HC ELSE 0 END)',
        	'main_40' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'sub_40' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'backup_40' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_40 ELSE 0 END)',
        	'main_20' => 'SUM(CASE WHEN PATINDEX(\'%MAIN%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        	'sub_20' => 'SUM(CASE WHEN PATINDEX(\'%SUB%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        	'backup_20' => 'SUM(CASE WHEN PATINDEX(\'%BACK-UP%\', FLAG_DESC) > 0 THEN CNT_20 ELSE 0 END)',
        ])
        ->where([
            'AND',
            ['>=', 'ETD', $model->from_date],
            ['<=', 'ETD', $model->to_date]
        ])
        ->one();

        return $this->render('ship-reservation-summary', [
            'model' => $model,
            'tmp_reservation_summary' => $tmp_reservation_summary,
        ]);
	}
}