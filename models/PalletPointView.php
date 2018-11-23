<?php

namespace app\models;

use Yii;
use \app\models\base\PalletPointView as BasePalletPointView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "pallet_point_view".
 */
class PalletPointView extends BasePalletPointView
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
