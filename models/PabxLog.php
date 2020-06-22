<?php

namespace app\models;

use Yii;
use \app\models\base\PabxLog as BasePabxLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PABX_LOG".
 */
class PabxLog extends BasePabxLog
{
    public $total_seluler, $total_fixed_line;

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
