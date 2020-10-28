<?php

namespace app\models;

use Yii;
use \app\models\base\IjazahItem as BaseIjazahItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IJAZAH_ITEM".
 */
class IjazahItem extends BaseIjazahItem
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
