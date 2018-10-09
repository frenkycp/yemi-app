<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "db_owner.ABSENSI_TBL".
 *
 * @property string $NIK_DATE_ID
 * @property string $NO
 * @property string $NIK
 * @property string $CC_ID
 * @property string $SECTION
 * @property string $DIRECT_INDIRECT
 * @property string $NAMA_KARYAWAN
 * @property integer $YEAR
 * @property string $PERIOD
 * @property integer $WEEK
 * @property string $DATE
 * @property string $NOTE
 * @property string $DAY_STAT
 * @property string $CATEGORY
 * @property integer $TOTAL_KARYAWAN
 * @property integer $KEHADIRAN
 * @property integer $BONUS
 * @property integer $DISIPLIN
 * @property string $CHECK_IN
 * @property string $CHECK_OUT
 * @property string $SHIFT
 * @property integer $CHECK_CLOCK
 * @property string $aliasModel
 */
abstract class AbsensiTbl extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'db_owner.ABSENSI_TBL';
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
            [['NIK_DATE_ID'], 'required'],
            [['NIK_DATE_ID', 'NO', 'NIK', 'CC_ID', 'SECTION', 'DIRECT_INDIRECT', 'NAMA_KARYAWAN', 'PERIOD', 'NOTE', 'DAY_STAT', 'CATEGORY', 'SHIFT'], 'string'],
            [['YEAR', 'WEEK', 'TOTAL_KARYAWAN', 'KEHADIRAN', 'BONUS', 'DISIPLIN', 'CHECK_CLOCK'], 'integer'],
            [['DATE', 'CHECK_IN', 'CHECK_OUT'], 'safe'],
            [['NIK_DATE_ID'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'NIK_DATE_ID' => 'Nik  Date  ID',
            'NO' => 'No',
            'NIK' => 'Nik',
            'CC_ID' => 'Cc  ID',
            'SECTION' => 'Section',
            'DIRECT_INDIRECT' => 'Direct  Indirect',
            'NAMA_KARYAWAN' => 'Nama  Karyawan',
            'YEAR' => 'Year',
            'PERIOD' => 'Period',
            'WEEK' => 'Week',
            'DATE' => 'Date',
            'NOTE' => 'Note',
            'DAY_STAT' => 'Day  Stat',
            'CATEGORY' => 'Category',
            'TOTAL_KARYAWAN' => 'Total  Karyawan',
            'KEHADIRAN' => 'Kehadiran',
            'BONUS' => 'Bonus',
            'DISIPLIN' => 'Disiplin',
            'CHECK_IN' => 'Check  In',
            'CHECK_OUT' => 'Check  Out',
            'SHIFT' => 'Shift',
            'CHECK_CLOCK' => 'Check  Clock',
        ];
    }




}
