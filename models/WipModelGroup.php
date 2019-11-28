<?php

namespace app\models;

use Yii;
use \app\models\base\WipModelGroup as BaseWipModelGroup;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_MODEL_GROUP".
 */
class WipModelGroup extends BaseWipModelGroup
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
