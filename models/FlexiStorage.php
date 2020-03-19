<?php

namespace app\models;

use Yii;
use \app\models\base\FlexiStorage as BaseFlexiStorage;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.FLEXI_STORAGE".
 */
class FlexiStorage extends BaseFlexiStorage
{
    public $balance, $storage_status;

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
