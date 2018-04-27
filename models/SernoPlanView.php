<?php

namespace app\models;

use Yii;
use \app\models\base\SernoPlan as BaseSernoPlan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_serno_plan".
 */
class SernoPlanView extends BaseSernoPlan
{
    public static function tableName()
    {
        return 'serno_plan_view';
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
