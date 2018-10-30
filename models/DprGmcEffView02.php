<?php

namespace app\models;

use Yii;
use \app\models\base\DprGmcEffView02 as BaseDprGmcEffView02;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_gmc_eff_view_02".
 */
class DprGmcEffView02 extends BaseDprGmcEffView02
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
