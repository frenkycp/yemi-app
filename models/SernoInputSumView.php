<?php

namespace app\models;

use Yii;
use \app\models\base\SernoInput as BaseSernoInput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_input".
 */
class SernoInput extends BaseSernoInput
{
    public static function tableName()
    {
        return 'tb_serno_input';
    }

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
