<?php

namespace app\models;

use Yii;
use \app\models\base\SernoOutput as BaseSernoOutput;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "serno_output_view_wee".
 */
class SernoOutputViewWeek extends BaseSernoOutput
{
    public static function tableName()
    {
        return 'serno_output_view_week';
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
