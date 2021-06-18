<?php

namespace app\models;

use Yii;
use \app\models\base\ShipLiner as BaseShipLiner;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIP_LINER".
 */
class ShipLiner extends BaseShipLiner
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
        date_default_timezone_set('Asia/Jakarta');
        if(parent::beforeSave($insert)){
            if (isset(\Yii::$app->params['ship_carrier_flag'][$this->FLAG_DESC])) {
                $this->FLAG_PRIORITY = \Yii::$app->params['ship_carrier_flag'][$this->FLAG_DESC];
            }
            
            return true;
        }
    }

    public function getCarrierDesc($value='')
    {
        return $this->CARRIER . ' (' . $this->FLAG_DESC . ')';
    }
}
