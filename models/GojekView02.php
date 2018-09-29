<?php

namespace app\models;

use Yii;
use \app\models\base\GojekView02 as BaseGojekView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GOJEK_VIEW_02".
 */
class GojekView02 extends BaseGojekView02
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
