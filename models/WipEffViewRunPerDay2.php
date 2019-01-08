<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffViewRunPerDay2 as BaseWipEffViewRunPerDay2;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_VIEW_RUN_PER_DAY2".
 */
class WipEffViewRunPerDay2 extends BaseWipEffViewRunPerDay2
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
