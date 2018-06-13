<?php

namespace app\models;

use Yii;
use \app\models\base\WeeklyPlan as BaseWeeklyPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_weekly_plan".
 */
class WeeklyPlan extends BaseWeeklyPlan
{
    public $percentage = 0, $week_range, $perccentage_export;

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
                [['percentage'], 'number'],
            ]
        );
    }
    
    function getStartAndEndDate($week, $year) {
        $dto = new \DateTime();
        $ret['week_start'] = $dto->setISODate($year, $week)->format('d M Y');
        //$ret['week_start'] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
        $ret['week_end'] = $dto->modify('+6 days')->format('d M Y');
        //$ret['week_end'] = date("Y-m-d", strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT).' +6 days'));
        return $ret;
    }
    
    public function getActualQty()
    {
        $outputWeek = SernoOutputViewWeek::find()->where(['id' => $this->period, 'week_no' => $this->week])->one();
        return $outputWeek != NULL ? $outputWeek->output : 0;
    }
    
    public function getBalanceQty()
    {
        $planQty = $this->plan_qty;
        $actualQty = $this->getActualQty();
        return $actualQty - $planQty;
    }
    
    public function getWeekPercentage()
    {
        $planQty = $this->plan_qty;
        $actualQty = $this->getActualQty();
        $presentase = 0;
        if ($planQty > 0) {
            $presentase = round(($actualQty / $planQty) * 100, 1);
        }
        
        return $presentase . '%';
    }

    public function getWeekPercentageExport()
    {
        $planQty = $this->plan_export;
        $actualQty = $this->actual_export;
        $presentase = 0;
        if ($planQty > 0) {
            $presentase = round(($actualQty / $planQty) * 100, 1);
        }
        return $presentase . '%';
    }

    public function getCalendarView()
    {
        return $this->hasOne(CalendarView::className(), ['week_ship' => 'week']);
    }

    public function getWeekStartDate()
    {
        $calendar = SernoCalendar::find()->where(['week_ship' => $this->week])->orderBy('ship ASC')->one();
        return $calendar->ship;
    }

    public function getWeekEndDate()
    {
        $calendar = SernoCalendar::find()->where(['week_ship' => $this->week])->orderBy('ship DESC')->one();
        return $calendar->ship;
    }
}
