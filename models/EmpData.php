<?php

namespace app\models;

use Yii;
use \app\models\base\MpInOut as BaseMpInOut;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.MP_IN_OUT".
 */
class EmpData extends BaseMpInOut
{
    public $total_emp, $category;

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

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'NIK' => 'NIK',
            ]
        );
    }
}
