<?php

namespace app\models;

use Yii;
use \app\models\base\PalletUtilityView203 as BasePalletUtilityView203;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pallet_utility_view2_03".
 */
class PalletUtilityView203 extends BasePalletUtilityView203
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
