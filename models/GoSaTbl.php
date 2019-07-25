<?php

namespace app\models;

use Yii;
use \app\models\base\GoSaTbl as BaseGoSaTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.GO_SA_TBL".
 */
class GoSaTbl extends BaseGoSaTbl
{
    public $emp;

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
            parent::rules(),
            [
                'employees' => 'Operator'
            ]
        );
    }
}
