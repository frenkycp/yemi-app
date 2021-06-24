<?php

namespace app\models;

use Yii;
use \app\models\base\TaxHdr as BaseTaxHdr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TAX_HDR".
 */
class TaxHdr extends BaseTaxHdr
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
