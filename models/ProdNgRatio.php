<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgRatio as BaseProdNgRatio;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_RATIO".
 */
class ProdNgRatio extends BaseProdNgRatio
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
