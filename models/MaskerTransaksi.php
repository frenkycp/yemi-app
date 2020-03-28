<?php

namespace app\models;

use Yii;
use \app\models\base\MaskerTransaksi as BaseMaskerTransaksi;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_transaksi".
 */
class MaskerTransaksi extends BaseMaskerTransaksi
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
