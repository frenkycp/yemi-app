<?php

namespace app\models;

use Yii;
use \app\models\base\DriverTbl as BaseDriverTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_driver".
 */
class DriverTbl extends BaseDriverTbl
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
