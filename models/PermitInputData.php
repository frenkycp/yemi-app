<?php

namespace app\models;

use Yii;
use \app\models\base\PermitInputData as BasePermitInputData;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tb_permit_input".
 */
class PermitInputData extends BasePermitInputData
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
