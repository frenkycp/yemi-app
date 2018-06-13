<?php

namespace app\models;

use Yii;
use \app\models\base\MesinCheckHistory as BaseMesinCheckHistory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MESIN_CHECK_HISTORY".
 */
class MesinCheckHistory extends BaseMesinCheckHistory
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
