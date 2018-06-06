<?php

namespace app\models;

use Yii;
use \app\models\base\JobOrderView4 as BaseJobOrderView4;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.JOB_ORDER_VIEW4".
 */
class JobOrderView4 extends BaseJobOrderView4
{
    public $loc;

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
