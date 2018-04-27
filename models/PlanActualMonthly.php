<?php

namespace app\models;

use Yii;
use app\models\base\SernoFg as BaseSernoFg;

class PlanActualMonthly extends BaseSernoFg
{
    public static function tableName()
    {
        return 'plan_aktual_percent_monthly';
    }
    
    public function rules()
    {
        return [
            [['bulan'], 'string', 'max' => 10],
            [['plan', 'aktual', 'persentase'], 'number'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'tgl_cont' => 'Tanggal',
            'plan' => 'Plan',
            'aktual' => 'Aktual',
            'persentase' => 'Persentase',
        ];
    }
    
    public static function getDb()
    {
            return Yii::$app->get('db_mis7');
    }
}