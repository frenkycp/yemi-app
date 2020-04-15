<?php

namespace app\models;

use Yii;
use \app\models\base\ShippingMonthlySummary as BaseShippingMonthlySummary;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIPPING_MONTHLY_SUMMARY".
 */
class ShippingMonthlySummary extends BaseShippingMonthlySummary
{

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

    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            $this->final_product_ratio = round(($this->final_product_act / $this->final_product_so) * 100, 2);
            $this->kd_ratio = round(($this->kd_act / $this->kd_so) * 100, 2);
            return true;
        }
    }//end beforeSave()

}
