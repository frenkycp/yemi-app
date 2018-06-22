<?php

namespace app\models;

use Yii;
use \app\models\base\ProductionInspection as BaseProductionInspection;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "inspection".
 */
class ProductionInspection extends BaseProductionInspection
{
    public $min_week, $max_week, $total;

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
