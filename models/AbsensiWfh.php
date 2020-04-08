<?php

namespace app\models;

use Yii;
use \app\models\base\AbsensiWfh as BaseAbsensiWfh;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ABSENSI_WFH".
 */
class AbsensiWfh extends BaseAbsensiWfh
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
