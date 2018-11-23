<?php

namespace app\models;

use Yii;
use \app\models\base\PalletPointView02 as BasePalletPointView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pallet_point_view_02".
 */
class PalletPointView02 extends BasePalletPointView02
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
