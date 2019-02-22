<?php

namespace app\models;

use Yii;
use \app\models\base\DrsView03 as BaseDrsView03;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.DRS_VIEW_03".
 */
class DrsView03 extends BaseDrsView03
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
