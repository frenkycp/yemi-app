<?php

namespace app\models;

use Yii;
use \app\models\base\ProdNgSernoView as BaseProdNgSernoView;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.PROD_NG_SERNO_VIEW".
 */
class ProdNgSernoView extends BaseProdNgSernoView
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
