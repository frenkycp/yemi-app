<?php

namespace app\models;

use Yii;
use \app\models\base\GojekOrderView01 as BaseGojekOrderView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_ORDER_VIEW_01".
 */
class GojekOrderView01 extends BaseGojekOrderView01
{
    public $qty_open, $qty_close;

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
