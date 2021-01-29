<?php

namespace app\models;

use Yii;
use \app\models\base\SapItemModelUsed as BaseSapItemModelUsed;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.sap_item_model_used".
 */
class SapItemModelUsed extends BaseSapItemModelUsed
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
