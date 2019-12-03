<?php

namespace app\models;

use Yii;
use \app\models\base\DrossStock as BaseDrossStock;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "stock_dross".
 */
class DrossStock extends BaseDrossStock
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
