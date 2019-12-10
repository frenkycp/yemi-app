<?php

namespace app\models;

use Yii;
use \app\models\base\PlanReceiving as BasePlanReceiving;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "plan_receiving".
 */
class PlanReceiving extends BasePlanReceiving
{
	public $total_qty, $min_year, $total_container, $total_truck, $total_wb, $week_no;

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
                [['receiving_date', 'vendor_name', 'container_no', 'qty'], 'required'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'cut_off_date' => 'Cut Off Date',
                'etd_port_date' => 'ETD Port',
                'eta_port_date' => 'ETA Port',
                'eta_yemi_date' => 'ETA YEMI',
            ]
        );
    }
}
