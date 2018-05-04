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
    public $percentage = 0;

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
        $presentase = ($actualQty / $planQty);
        return $presentase;
    }
}
