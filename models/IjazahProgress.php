<?php

namespace app\models;

use Yii;
use \app\models\base\IjazahProgress as BaseIjazahProgress;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.IJAZAH_PROGRESS".
 */
class IjazahProgress extends BaseIjazahProgress
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
