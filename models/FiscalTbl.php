<?php

namespace app\models;

use Yii;
use \app\models\base\FiscalTbl as BaseFiscalTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.FISCAL_TBL".
 */
class FiscalTbl extends BaseFiscalTbl
{
    public $min_period, $max_period;

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
