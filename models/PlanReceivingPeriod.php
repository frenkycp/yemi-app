<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * summary
 */
class PlanReceivingPeriod extends Model
{
    public $month;
    public $year;

    public function rules()
    {
        return [
            [['month', 'year'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'month' => 'Month',
            'year' => 'Year',
        ];
    }
}