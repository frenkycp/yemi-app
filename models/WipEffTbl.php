<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffTbl as BaseWipEffTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_TBL".
 */
class WipEffTbl extends BaseWipEffTbl
{
    public $target_qty, $actual_qty, $total_nett, $total_dandori;

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
