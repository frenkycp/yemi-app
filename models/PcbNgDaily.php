<?php

namespace app\models;

use Yii;
use \app\models\base\PcbNgDaily as BasePcbNgDaily;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pcb_ng_daily_01".
 */
class PcbNgDaily extends BasePcbNgDaily
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
}
