<?php

namespace app\models;

use Yii;
use \app\models\base\WipStock02 as BaseWipStock02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_STOCK_02".
 */
class WipStock02 extends BaseWipStock02
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
