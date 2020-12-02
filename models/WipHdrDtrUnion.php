<?php

namespace app\models;

use Yii;
use \app\models\base\WipHdrDtrUnion as BaseWipHdrDtrUnion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_HDR_DTR_UNION".
 */
class WipHdrDtrUnion extends BaseWipHdrDtrUnion
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
