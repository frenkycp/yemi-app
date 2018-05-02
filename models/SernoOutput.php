<?php

namespace app\models;

use Yii;
use \app\models\base\SernoOutput as BaseSernoOutput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_output".
 */
class SernoOutput extends BaseSernoOutput
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
    
    public static function getDb()
    {
            return Yii::$app->get('db_mis7');
    }
}
