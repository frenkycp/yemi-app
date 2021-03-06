<?php

namespace app\models;

use Yii;
use \app\models\base\WeeklySummaryView as BaseWeeklySummaryView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "weekly_summary_view".
 */
class WeeklySummaryView extends BaseWeeklySummaryView
{
    public $total_target, $total_close, $total_sent;

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getWeekStartDate()
    {
        $calendar = SernoCalendar::find()->where([
            'week_ship' => $this->week_no,
        ])
        ->andWhere(['>', 'ship', date('Y-m-d', strtotime($this->getWeekEndDate() . ' -1 month'))])
        ->orderBy('ship ASC')->one();
        return $calendar->ship;
    }

    public function getWeekEndDate()
    {
        $calendar = SernoCalendar::find()->where([
            'week_ship' => $this->week_no,
        ])->orderBy('ship DESC')->one();
        return $calendar->ship;
    }

    public function getWeekPercentage()
    {
        $plan_qty = $this->plan_qty;
        $actual_qty = $this->actual_qty;
        $presentase = 0;
        if ($plan_qty > 0) {
            $presentase = round(($actual_qty / $plan_qty) * 100, 2);
        }
        
        return $presentase . '%';
    }

    public function getWeekPercentageExport()
    {
        $planQty = $this->plan_export;
        $actualQty = $this->actual_export;
        $presentase = 0;
        if ($planQty > 0) {
            $presentase = round(($actualQty / $planQty) * 100, 2);
        }
        return $presentase . '%';
    }

    public function getDelayQty()
    {
        $data_arr = SernoInput::find()
        ->joinWith('sernoOutput')
        ->select([
            'total' => 'COUNT(*)'
        ])
        ->where([
            'WEEK(tb_serno_output.ship,4)' => $this->week_no,
        ])
        ->andWhere('tb_serno_input.proddate > tb_serno_output.etd')
        ->one();

        return $data_arr->total;
    }

    public function getDelayPercentage()
    {
        $percentage = 0;
        $plan_qty = $this->plan_qty;
        if ($plan_qty > 0) {
            $percentage = round(($this->getDelayQty() / $plan_qty) * 100, 2);
        }
        return $percentage . '%';
    }

    public function getOnTimeCompletion()
    {
        $percentage = 0;
        $plan_qty = $this->plan_qty;
        if ($plan_qty > 0) {
            $percentage = round((($this->actual_qty - $this->getDelayQty()) / $plan_qty) * 100, 2);
        }
        return $percentage . '%';
    }
}
