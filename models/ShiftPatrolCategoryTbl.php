<?php

namespace app\models;

use Yii;
use \app\models\base\ShiftPatrolCategoryTbl as BaseShiftPatrolCategoryTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIFT_PATROL_CATEGORY_TBL".
 */
class ShiftPatrolCategoryTbl extends BaseShiftPatrolCategoryTbl
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
