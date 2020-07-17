<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tbl_karyawan".
 *
 * @property string $nik_karyawan
 * @property string $nama_karyawan
 * @property string $dept_karyawan
 * @property string $telp_karyawan
 * @property string $status_karyawan
 * @property string $password_karyawan
 * @property string $hak_akses_karyawan
 * @property string $aliasModel
 */
abstract class BentolKaryawan extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_karyawan';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_bentol');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nik_karyawan', 'nama_karyawan', 'dept_karyawan', 'telp_karyawan', 'status_karyawan', 'password_karyawan', 'hak_akses_karyawan'], 'required'],
            [['nik_karyawan', 'nama_karyawan', 'dept_karyawan', 'telp_karyawan', 'status_karyawan', 'password_karyawan', 'hak_akses_karyawan'], 'string', 'max' => 100],
            [['nik_karyawan'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nik_karyawan' => 'Nik Karyawan',
            'nama_karyawan' => 'Nama Karyawan',
            'dept_karyawan' => 'Dept Karyawan',
            'telp_karyawan' => 'Telp Karyawan',
            'status_karyawan' => 'Status Karyawan',
            'password_karyawan' => 'Password Karyawan',
            'hak_akses_karyawan' => 'Hak Akses Karyawan',
        ];
    }




}
