<?php

namespace app\models;

use Yii;
use \app\models\base\AbsensiTbl as BaseAbsensiTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.ABSENSI_TBL".
 */
class AbsensiTbl extends BaseAbsensiTbl
{
    public $min_year, $total_kehadiran, $total_karyawan;

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
                'date' => 'Tanggal',
                'NIK' => 'NIK',
            ]
        );
    }
}
