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

/**
 * 
 */
class DisplayLogController extends Controller
{
    public function actionShippingOrder($value='')
    {
        $this->layout = 'clean';
        date_default_timezone_set('Asia/Jakarta');

        $today = date('Y-m-d');
        $tmp_yesterday = WorkDayTbl::find()
        ->select([
            'cal_date' => 'FORMAT(cal_date, \'yyyy-MM-dd\')'
        ])
        ->where([
            '<', 'FORMAT(cal_date, \'yyyy-MM-dd\')', $today
        ])
        ->andWhere('holiday IS NULL')
        ->orderBy('cal_date DESC')
        ->one();
        $yesterday = date('Y-m-d', strtotime($tmp_yesterday->cal_date));

        $yesterday_period = date('Ym', strtotime($yesterday));

        $tmp_total_container = ShipReservationView02::find()
        ->select([
            'POD',
            'total_all' => 'SUM(total_container)',
            'total_confirm' => 'SUM(CASE WHEN STATUS_CONFIRMED = \'CONFIRMED\' THEN total_container ELSE 0 END)',
            'total_not_confirm' => 'SUM(CASE WHEN STATUS_CONFIRMED = \'NOT CONFIRMED\' THEN total_container ELSE 0 END)'
        ])
        ->where(['PERIOD' => $yesterday_period])
        ->groupBy('POD')
        ->orderBy('POD')
        ->all();

        $total_plan = $total_confirm = $total_not_confirm = 0;
        $data_arr = [];
        foreach ($tmp_total_container as $key => $value) {
            $total_plan += $value->total_all;
            $total_confirm += $value->total_confirm;
            $total_not_confirm += $value->total_not_confirm;
            $data_arr[$value->POD] = [
                'plan' => $value->total_all,
                'confirm' => $value->total_confirm,
                'not_confirm' => $value->total_not_confirm
            ];
        }

        return $this->render('shipping-order', [
            'data' => $data,
            'total_plan' => $total_plan,
            'total_ship_out' => $total_ship_out,
            'yesterday' => $yesterday,
            'total_confirm' => $total_confirm,
            'total_not_confirm' => $total_not_confirm,
            'data_arr' => $data_arr,
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