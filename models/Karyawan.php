<?php

namespace app\models;

use Yii;
use \app\models\base\Karyawan as BaseKaryawan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.KARYAWAN".
 */
class Karyawan extends BaseKaryawan
{
    public $cuti, $kontrak_start, $kontrak_end;
    
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
