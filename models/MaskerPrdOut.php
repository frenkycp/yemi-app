<?php

namespace app\models;

use Yii;
use \app\models\base\MaskerPrdOut as BaseMaskerPrdOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "detilkeluarbarang".
 */
class MaskerPrdOut extends BaseMaskerPrdOut
{
    public $total, $post_date;

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
