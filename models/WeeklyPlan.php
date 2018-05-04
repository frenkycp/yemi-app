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
        $presentase = round(($actualQty / $planQty) * 100);
        return $presentase . '%';
    }
}
