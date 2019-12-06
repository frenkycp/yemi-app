<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tb_klinik_input".
 *
 * @property string $pk
 * @property string $nik
 * @property string $nama
 * @property string $CC_ID
 * @property string $dept
 * @property string $section
 * @property string $status_karyawan
 * @property integer $opsi
 * @property string $masuk
 * @property string $keluar
 * @property string $anamnesa
 * @property string $root_cause
 * @property string $diagnosa
 * @property string $obat1
 * @property string $obat2
 * @property string $obat3
 * @property string $obat4
 * @property string $obat5
 * @property string $handleby
 * @property integer $confirm
 * @property string $last_status
 * @property string $aliasModel
 */
abstract class KlinikInput extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tb_klinik_input';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_mis7');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk'], 'required'],
            [['pk', 'masuk', 'keluar'], 'safe'],
            [['opsi', 'confirm'], 'integer'],
            [['nik', 'status_karyawan'], 'string', 'max' => 20],
            [['nama', 'dept', 'anamnesa', 'root_cause', 'diagnosa', 'obat1', 'obat2', 'obat3', 'obat4', 'obat5', 'handleby'], 'string', 'max' => 255],
            [['CC_ID'], 'string', 'max' => 10],
            [['section'], 'string', 'max' => 50],
            [['last_status'], 'string', 'max' => 30],
            [['pk'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pk' => 'Pk',
            'nik' => 'Nik',
            'nama' => 'Nama',
            'CC_ID' => 'Cc ID',
            'dept' => 'Dept',
            'section' => 'Section',
            'status_karyawan' => 'Status Karyawan',
            'opsi' => 'Opsi',
            'masuk' => 'Masuk',
            'keluar' => 'Keluar',
            'anamnesa' => 'Anamnesa',
            'root_cause' => 'Root Cause',
            'diagnosa' => 'Diagnosa',
            'obat1' => 'Obat1',
            'obat2' => 'Obat2',
            'obat3' => 'Obat3',
            'obat4' => 'Obat4',
            'obat5' => 'Obat5',
            'handleby' => 'Handleby',
            'confirm' => 'Confirm',
            'last_status' => 'Last Status',
        ];
    }




}
