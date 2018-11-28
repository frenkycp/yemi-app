<?php

namespace app\models;

use Yii;
use \app\models\base\PalletUtilityView03 as BasePalletUtilityView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pallet_utility_view_03".
 */
class PalletUtilityView03 extends BasePalletUtilityView03
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
