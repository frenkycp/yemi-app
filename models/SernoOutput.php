<?php

namespace app\models;

use Yii;
use \app\models\base\SernoOutput as BaseSernoOutput;
use yii\helpers\ArrayHelper;
use app\models\SernoMaster;

/**
 * This is the model class for table "tb_serno_output".
 */
class SernoOutput extends BaseSernoOutput
{
    public $description, $week_no, $cust_desc, $plan_actual, $part_full_desc, $balance, $total_cntr, $max_week, $min_week, $tahun, $is_minus, $stock_qty, $total_delay, $monthly_total_plan, $monthly_progress_plan, $monthly_progress_output, $monthly_progress_delay, $total_qty, $total_output, $min_year, $evidence_file, $achievement, $total_ok, $plan_qty, $actual_qty, $status, $bu, $period, $line, $plan_standard_price, $week_ship;

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
                [['description'], 'safe']
            ]
        );
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stc' => 'Stc',
            'dst' => 'Destination',
            'num' => 'Num',
            'gmc' => 'GMC',
            'qty' => 'Plan',
            'output' => 'Actual',
            'adv' => 'Adv',
            //'ng' => 'NG',
            'etd' => 'Etd',
            'cntr' => 'Cntr',
            'cust_desc' => 'Customer Description',
            'category' => 'Category',
            'remark' => 'Remark'
        ];
    }
    
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }
    
    public function getQtyBalance()
    {
        return $this->output - $this->qty;
    }

    public function getSernoMaster()
    {
        return $this->hasOne(SernoMaster::className(), ['gmc' => 'gmc']);
    }

    public function getPartName()
    {
        $sernoMaster = SernoMaster::find()->where(['gmc' => $this->gmc])->one();
        return $sernoMaster->model . ' // ' . $sernoMaster->color . ' // ' . $sernoMaster->dest;
    }

    public function getShipCustomer()
    {
        return $this->hasOne(ShipCustomer::className(), ['customer_code' => 'stc']);
    }

    public function getItemM3()
    {
        return $this->hasOne(ShipItemM3::className(), ['ITEM' => 'gmc'])->one();
    }

    public function getSernoInput()
    {
        return $this->hasMany(SernoInput::className(), ['plan' => 'pk']);
    }
    public function getSernoCnt()
    {
        return $this->hasOne(SernoCnt::className(), ['cnt' => 'cntr']);
    }
}
