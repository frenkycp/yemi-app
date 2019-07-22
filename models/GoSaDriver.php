<?php

namespace app\models;

use Yii;
use \app\models\base\GoSaDriver as BaseGoSaDriver;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GO_SA_DRIVER".
 */
class GoSaDriver extends BaseGoSaDriver
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
