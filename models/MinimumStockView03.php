<?php

namespace app\models;

use Yii;
use \app\models\base\MinimumStockView03 as BaseMinimumStockView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MINIMUM_STOCK_VIEW_03".
 */
class MinimumStockView03 extends BaseMinimumStockView03
{
    public $budget;
    
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
