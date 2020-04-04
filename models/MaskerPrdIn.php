<?php

namespace app\models;

use Yii;
use \app\models\base\MaskerPrdIn as BaseMaskerPrdIn;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_incoming".
 */
class MaskerPrdIn extends BaseMaskerPrdIn
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
