<?php

namespace app\models;

use Yii;
use \app\models\base\PcPiVariance as BasePcPiVariance;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PC_PI_VARIANCE".
 */
class PcPiVariance extends BasePcPiVariance
{
    public $total;

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
