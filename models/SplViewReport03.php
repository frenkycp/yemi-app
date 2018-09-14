<?php

namespace app\models;

use Yii;
use \app\models\base\SplViewReport03 as BaseSplViewReport03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_VIEW_REPORT_03".
 */
class SplViewReport03 extends BaseSplViewReport03
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
