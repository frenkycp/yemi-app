<?php

namespace app\models;

use Yii;
use \app\models\base\ShePatrolArea as BaseShePatrolArea;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHE_PATROL_AREA".
 */
class ShePatrolArea extends BaseShePatrolArea
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
