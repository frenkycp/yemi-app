<?php

namespace app\models;

use Yii;
use \app\models\base\MaskerPrdStock as BaseMaskerPrdStock;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "barang_in".
 */
class MaskerPrdStock extends BaseMaskerPrdStock
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
