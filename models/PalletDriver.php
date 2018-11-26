<?php

namespace app\models;

use Yii;
use \app\models\base\PalletDriver as BasePalletDriver;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_pallet_driver".
 */
class PalletDriver extends BasePalletDriver
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
