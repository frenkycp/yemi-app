<?php

namespace app\models;

use Yii;
use \app\models\base\WipEffView as BaseWipEffView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.WIP_EFF_VIEW".
 */
class WipEffView extends BaseWipEffView
{
    public $gross_eff, $nett_eff;

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
