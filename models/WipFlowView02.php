<?php

namespace app\models;

use Yii;
use \app\models\base\WipFlowView02 as BaseWipFlowView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_FLOW_VIEW_02".
 */
class WipFlowView02 extends BaseWipFlowView02
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
