<?php

namespace app\models;

use Yii;
use \app\models\base\MasterplanHistory as BaseMasterplanHistory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_RESULT_SUM".
 */
class MasterplanHistory extends BaseMasterplanHistory
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
