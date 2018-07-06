<?php

namespace app\models;

use Yii;
use \app\models\base\SplHdr as BaseSplHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SPL_HDR".
 */
class SplHdr extends BaseSplHdr
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
