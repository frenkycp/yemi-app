<?php

namespace app\models;

use Yii;
use \app\models\base\SernoFg as BaseSernoFg;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_fg".
 */
class SernoFgSumView extends BaseSernoFg
{
    public static function tableName()
    {
        return 'tb_serno_fg_view';
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
    
    public static function getDb()
    {
            return Yii::$app->get('db_mis7');
    }
}
