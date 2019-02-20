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
    public $min_year, $total_kehadiran, $total_karyawan, $total_cuti, $CUTI, $CUTI_KHUSUS, $ALPHA, $IJIN, $SAKIT, $NO_DISIPLIN, $DATANG_TERLAMBAT, $PULANG_CEPAT, $SHIFT1, $SHIFT2, $SHIFT3, $SHIFT4, $total, $filter_category;

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
