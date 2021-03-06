<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "tbl_manager_trip".
 *
 * @property string $kode_manager_trip
 * @property string $datetime_input_manager_trip
 * @property string $date_manager_trip
 * @property string $jenis_manager_trip
 * @property string $nik_manager_trip
 * @property string $nama_manager_trip
 * @property string $dept_manager_trip
 * @property string $kode_domisili_trip
 * @property string $desc_domisili_trip
 * @property double $jarak_domisili_trip
 * @property double $tarif_bbm_trip
 * @property double $total_bbm_trip
 * @property string $jam_awal_trip
 * @property string $jam_akhir_trip
 * @property double $tol_1
 * @property double $tol_2
 * @property double $tol_3
 * @property double $tol_4
 * @property double $tol_5
 * @property string $ket_tol1
 * @property string $ket_tol2
 * @property string $ket_tol3
 * @property string $ket_tol4
 * @property string $ket_tol5
 * @property integer $status_validasi
 * @property string $validasi_by
 * @property string $datetime_validasi
 * @property string $aliasModel
 */
abstract class BentolManagerTrip extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_manager_trip';
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
            [['kode_manager_trip', 'datetime_input_manager_trip', 'date_manager_trip', 'jenis_manager_trip', 'nik_manager_trip', 'nama_manager_trip', 'dept_manager_trip', 'kode_domisili_trip', 'desc_domisili_trip', 'jarak_domisili_trip', 'tarif_bbm_trip', 'total_bbm_trip', 'jam_awal_trip', 'jam_akhir_trip', 'tol_1', 'tol_2', 'tol_3', 'tol_4', 'tol_5', 'ket_tol1', 'ket_tol2', 'ket_tol3', 'ket_tol4', 'ket_tol5', 'status_validasi', 'validasi_by'], 'required'],
            [['datetime_input_manager_trip', 'date_manager_trip', 'jam_awal_trip', 'jam_akhir_trip', 'datetime_validasi'], 'safe'],
            [['jarak_domisili_trip', 'tarif_bbm_trip', 'total_bbm_trip', 'tol_1', 'tol_2', 'tol_3', 'tol_4', 'tol_5'], 'number'],
            [['status_validasi'], 'integer'],
            [['kode_manager_trip', 'jenis_manager_trip', 'nik_manager_trip', 'nama_manager_trip', 'dept_manager_trip', 'kode_domisili_trip', 'desc_domisili_trip', 'ket_tol1', 'ket_tol2', 'ket_tol3', 'ket_tol4', 'ket_tol5', 'validasi_by'], 'string', 'max' => 100],
            [['kode_manager_trip'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_manager_trip' => 'Kode Manager Trip',
            'datetime_input_manager_trip' => 'Datetime Input Manager Trip',
            'date_manager_trip' => 'Date Manager Trip',
            'jenis_manager_trip' => 'Jenis Manager Trip',
            'nik_manager_trip' => 'Nik Manager Trip',
            'nama_manager_trip' => 'Nama Manager Trip',
            'dept_manager_trip' => 'Dept Manager Trip',
            'kode_domisili_trip' => 'Kode Domisili Trip',
            'desc_domisili_trip' => 'Desc Domisili Trip',
            'jarak_domisili_trip' => 'Jarak Domisili Trip',
            'tarif_bbm_trip' => 'Tarif Bbm Trip',
            'total_bbm_trip' => 'Total Bbm Trip',
            'jam_awal_trip' => 'Jam Awal Trip',
            'jam_akhir_trip' => 'Jam Akhir Trip',
            'tol_1' => 'Tol 1',
            'tol_2' => 'Tol 2',
            'tol_3' => 'Tol 3',
            'tol_4' => 'Tol 4',
            'tol_5' => 'Tol 5',
            'ket_tol1' => 'Ket Tol1',
            'ket_tol2' => 'Ket Tol2',
            'ket_tol3' => 'Ket Tol3',
            'ket_tol4' => 'Ket Tol4',
            'ket_tol5' => 'Ket Tol5',
            'status_validasi' => 'Status Validasi',
            'validasi_by' => 'Validasi By',
            'datetime_validasi' => 'Datetime Validasi',
        ];
    }




}
