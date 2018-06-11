<?php

namespace app\models;

use Yii;
use \app\models\base\ItemM3 as BaseItemM3;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_item_m3".
 */
class ItemM3 extends BaseItemM3
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
