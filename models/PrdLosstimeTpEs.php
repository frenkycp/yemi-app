<?php

namespace app\models;

use Yii;
use \app\models\base\PrdLosstimeTpEs as BasePrdLosstimeTpEs;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PRD_LOSSTIME_TP_ES".
 */
class PrdLosstimeTpEs extends BasePrdLosstimeTpEs
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
