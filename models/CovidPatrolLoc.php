<?php

namespace app\models;

use Yii;
use \app\models\base\CovidPatrolLoc as BaseCovidPatrolLoc;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.COVID_PATROL_LOC".
 */
class CovidPatrolLoc extends BaseCovidPatrolLoc
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
