<?php

namespace app\models;

use Yii;
use \app\models\base\WorkDayTbl as BaseWorkDayTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.work_day_tbl".
 */
class WorkDayTbl extends BaseWorkDayTbl
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
