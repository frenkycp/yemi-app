<?php

namespace app\models;

use Yii;
use \app\models\base\DataRepair as BaseDataRepair;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "data_repair".
 */
class DataRepair extends BaseDataRepair
{
    public $total_return, $total_scrap, $total_ok;

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
