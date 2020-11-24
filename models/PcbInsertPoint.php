<?php

namespace app\models;

use Yii;
use \app\models\base\PcbInsertPoint as BasePcbInsertPoint;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PCB_INSERT_POINT".
 */
class PcbInsertPoint extends BasePcbInsertPoint
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
