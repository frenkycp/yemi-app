<?php

namespace app\models;

use Yii;
use \app\models\base\WipMpPlan as BaseWipMpPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_MP_PLAN".
 */
class WipMpPlan extends BaseWipMpPlan
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
