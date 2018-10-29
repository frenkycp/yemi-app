<?php

namespace app\models;

use Yii;
use \app\models\base\DprGmcEffView03 as BaseDprGmcEffView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_gmc_eff_view_03".
 */
class DprGmcEffView03 extends BaseDprGmcEffView03
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
