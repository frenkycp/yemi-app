<?php

namespace app\models;

use Yii;
use \app\models\base\WipHdrDtrBu as BaseWipHdrDtrBu;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_HDR_DTR_BU".
 */
class WipHdrDtrBu extends BaseWipHdrDtrBu
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
