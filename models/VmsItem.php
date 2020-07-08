<?php

namespace app\models;

use Yii;
use \app\models\base\VmsItem as BaseVmsItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.VMS_ITEM".
 */
class VmsItem extends BaseVmsItem
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
