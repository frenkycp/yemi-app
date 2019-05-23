<?php

namespace app\models;

use Yii;
use \app\models\base\MntShiftView as BaseMntShiftView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MNT_SHIFT_VIEW".
 */
class MntShiftView extends BaseMntShiftView
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
