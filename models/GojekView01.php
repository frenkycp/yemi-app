<?php

namespace app\models;

use Yii;
use \app\models\base\GojekView01 as BaseGojekView01;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_VIEW_01".
 */
class GojekView01 extends BaseGojekView01
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
