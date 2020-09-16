<?php

namespace app\models;

use Yii;
use \app\models\base\WipOutputMonthlyView as BaseWipOutputMonthlyView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_OUTPUT_MONTHLY_VIEW".
 */
class WipOutputMonthlyView extends BaseWipOutputMonthlyView
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
