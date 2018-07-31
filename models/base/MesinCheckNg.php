<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.MESIN_CHECK_NG".
 *
 * @property integer $urutan
 * @property string $location
 * @property string $area
 * @property string $mesin_id
 * @property string $mesin_nama
 * @property string $mesin_no
 * @property string $mesin_bagian
 * @property string $mesin_bagian_ket
 * @property string $mesin_status
 * @property string $mesin_catatan
 * @property string $mesin_periode
 * @property string $user_id
 * @property string $user_desc
 * @property string $mesin_last_update
 * @property string $repair_plan
 * @property string $repair_aktual
 * @property string $repair_user_id
 * @property string $repair_user_desc
 * @property string $repair_status
 * @property string $repair_pic
 * @property string $repair_note
 * @property integer $color_stat
 * @property integer $prepare_time
 * @property integer $repair_time
 * @property integer $spare_part_time
 * @property integer $install_time
 * @property string $aliasModel
 */
abstract class MesinCheckNg extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.MESIN_CHECK_NG';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sql_server');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location', 'area', 'mesin_id', 'mesin_nama', 'mesin_no', 'mesin_bagian', 'mesin_bagian_ket', 'mesin_status', 'mesin_catatan', 'mesin_periode', 'user_id', 'user_desc', 'repair_user_id', 'repair_user_desc', 'repair_status', 'repair_pic', 'repair_note'], 'string'],
            [['mesin_last_update', 'repair_plan', 'repair_aktual'], 'safe'],
            [['color_stat', 'prepare_time', 'repair_time', 'spare_part_time', 'install_time'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'urutan' => 'Urutan',
            'location' => 'Location',
            'area' => 'Area',
            'mesin_id' => 'Mesin ID',
            'mesin_nama' => 'Mesin Nama',
            'mesin_no' => 'Mesin No',
            'mesin_bagian' => 'Mesin Bagian',
            'mesin_bagian_ket' => 'Mesin Bagian Ket',
            'mesin_status' => 'Mesin Status',
            'mesin_catatan' => 'Mesin Catatan',
            'mesin_periode' => 'Mesin Periode',
            'user_id' => 'User ID',
            'user_desc' => 'User Desc',
            'mesin_last_update' => 'Mesin Last Update',
            'repair_plan' => 'Repair Plan',
            'repair_aktual' => 'Repair Aktual',
            'repair_user_id' => 'Repair User ID',
            'repair_user_desc' => 'Repair User Desc',
            'repair_status' => 'Repair Status',
            'repair_pic' => 'Repair Pic',
            'repair_note' => 'Repair Note',
            'color_stat' => 'Color Stat',
            'prepare_time' => 'Prepare Time',
            'repair_time' => 'Repair Time',
            'spare_part_time' => 'Spare Part Time',
            'install_time' => 'Install Time',
        ];
    }




}
