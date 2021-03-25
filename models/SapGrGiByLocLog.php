<?php

namespace app\models;

use Yii;
use \app\models\base\SapGrGiByLocLog as BaseSapGrGiByLocLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_gr_gi_by_loc_log".
 */
class SapGrGiByLocLog extends BaseSapGrGiByLocLog
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
