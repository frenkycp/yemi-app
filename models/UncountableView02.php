<?php

namespace app\models;

use Yii;
use \app\models\base\UncountableView02 as BaseUncountableView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.UNCOUNTABLE_VIEW_02".
 */
class UncountableView02 extends BaseUncountableView02
{
    public $MIN_DATE, $MAX_DATE;

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
