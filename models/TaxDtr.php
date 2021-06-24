<?php

namespace app\models;

use Yii;
use \app\models\base\TaxDtr as BaseTaxDtr;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.TAX_DTR".
 */
class TaxDtr extends BaseTaxDtr
{
    public $period;

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

    public function getTaxHdr()
    {
        return $this->hasOne(TaxHdr::className(), ['no_seri' => 'no_seri']);
    }
}
