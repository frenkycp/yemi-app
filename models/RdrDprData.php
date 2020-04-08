<?php

namespace app\models;

use Yii;
use \app\models\base\RdrDprData as BaseRdrDprData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.RDR_DPR".
 */
class RdrDprData extends BaseRdrDprData
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
