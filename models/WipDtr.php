<?php

namespace app\models;

use Yii;
use \app\models\base\WipDtr as BaseWipDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_DTR".
 */
class WipDtr extends BaseWipDtr
{
    public $location, $speaker_model;

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

    public function getWipHdr()
    {
        return $this->hasOne(WipHdr::className(), ['hdr_id_item' => 'hdr_id_item']);
    }

    public function getSummaryQty()
    {
        return $this->balance_by_day + $this->act_qty;
    }
}
