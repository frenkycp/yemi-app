<?php

namespace app\models;

use Yii;
use \app\models\base\CrusherBomModel as BaseCrusherBomModel;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.CRUSHER_BOM_MODEL".
 */
class CrusherBomModel extends BaseCrusherBomModel
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
