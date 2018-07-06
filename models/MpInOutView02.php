<?php

namespace app\models;

use Yii;
use \app\models\base\MpInOutView02 as BaseMpInOutView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MP_IN_OUT_VIEW_02".
 */
class MpInOutView02 extends BaseMpInOutView02
{
    public $total, $min_year;

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
