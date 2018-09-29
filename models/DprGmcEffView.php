<?php

namespace app\models;

use Yii;
use \app\models\base\DprGmcEffView as BaseDprGmcEffView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dpr_gmc_eff_view".
 */
class DprGmcEffView extends BaseDprGmcEffView
{
    public $total_mp;

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
