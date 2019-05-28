<?php

namespace app\models;

use Yii;
use \app\models\base\ShiftPatrolTbl as BaseShiftPatrolTbl;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "db_owner.SHIFT_PATROL_TBL".
 */
class ShiftPatrolTbl extends BaseShiftPatrolTbl
{
    public $upload_file1, $upload_file2, $posting_date, $time, $penilaian;

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
                [['patrol_time', 'category_id', 'location', 'description', 'patrol_type', 'status', 'section_id'], 'required'],
                [['upload_file1', 'upload_file2'], 'file'],
            ]
        );
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'NIK' => 'NIK',
                'NAMA_KARYAWAN' => 'Nama',
                'category_id' => 'Topik',
                'category_detail' => 'Detail Patrol',
                'patrol_time' => 'Waktu Patrol',
                'location' => 'Lokasi',
                'location_detail' => 'Detail Lokasi',
                'description' => 'Hasil Patrol',
                'action' => 'Tindakan/Saran',
                'attachment' => 'Gambar/Foto',
                'upload_file1' => 'Upload Gambar/Foto (Before)',
                'upload_file2' => 'Upload Gambar/Foto (After) - Jika Ada',
                'patrol_type' => 'Penilaian',
                'posting_date' => 'Tanggal',
                'time' => 'Jam',
                'section_id' => 'Section'
            ]
        );
    }

    public function getCategory()
    {
        return $this->hasOne(ShiftPatrolCategoryTbl::className(), ['id' => 'category_id'])->one();
    }
}
