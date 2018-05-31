<?php

namespace app\models;

use Yii;
use \app\models\base\JobOrderView3 as BaseJobOrderView3;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.JOB_ORDER_VIEW3".
 */
class JobOrderView3 extends BaseJobOrderView3
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
