<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckNg as BaseMesinCheckNg;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_NG".
 */
class MesinCheckNg extends BaseMesinCheckNg
{
    public $total_open, $total_close, $tgl, $closing_day_total, $period, $total;

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

    public static function getDb()
    {
            return Yii::$app->get('db_sql_server');
    }

    public function getClosingDayTotal()
    {
        $start_date = new \DateTime(date('Y-m-d', strtotime($this->mesin_last_update)));
        $end_date = new \DateTime(date('Y-m-d'));
        if ($this->repair_aktual !== null) {
            $end_date = new \DateTime(date('Y-m-d', strtotime($this->repair_aktual)));
        }

        return $start_date->diff($end_date)->format("%d");
    }
}
