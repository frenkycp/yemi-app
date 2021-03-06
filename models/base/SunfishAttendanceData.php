<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "dbo.VIEW_YEMI_ATTENDANCE".
 *
 * @property string $emp_no
 * @property string $full_name
 * @property string $emp_id
 * @property string $cost_center
 * @property string $shiftdaily_code
 * @property string $shiftstarttime
 * @property string $shiftendtime
 * @property string $starttime
 * @property string $endtime
 * @property double $total_ot
 * @property double $total_otindex
 * @property string $Attend_Code
 * @property string $attend_judgement
 * @property string $come_late
 * @property string $home_early
 * @property string $undisciplined
 * @property string $ovtrequest_no
 * @property string $ovtplanfrom
 * @property string $ovtplanto
 * @property string $ovtactfrom
 * @property string $ovtactto
 * @property string $attend_id
 * @property string $aliasModel
 */
abstract class SunfishAttendanceData extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbo.VIEW_YEMI_ATTENDANCE';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_sun_fish');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emp_no', 'emp_id', 'cost_center', 'shiftdaily_code', 'come_late', 'home_early', 'undisciplined', 'attend_id'], 'required'],
            [['shiftstarttime', 'shiftendtime', 'starttime', 'endtime', 'ovtplanfrom', 'ovtplanto', 'ovtactfrom', 'ovtactto'], 'safe'],
            [['total_ot', 'total_otindex'], 'number'],
            [['Attend_Code'], 'string'],
            [['emp_no', 'emp_id', 'cost_center', 'shiftdaily_code', 'ovtrequest_no', 'attend_id'], 'string', 'max' => 50],
            [['full_name'], 'string', 'max' => 302],
            [['attend_judgement'], 'string', 'max' => 3],
            [['come_late', 'home_early', 'undisciplined'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'full_name' => 'Full Name',
            'emp_id' => 'Emp ID',
            'cost_center' => 'Cost Center',
            'shiftdaily_code' => 'Shiftdaily Code',
            'shiftstarttime' => 'Shiftstarttime',
            'shiftendtime' => 'Shiftendtime',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
            'total_ot' => 'Total Ot',
            'total_otindex' => 'Total Otindex',
            'Attend_Code' => 'Attend Code',
            'attend_judgement' => 'Attend Judgement',
            'come_late' => 'Come Late',
            'home_early' => 'Home Early',
            'undisciplined' => 'Undisciplined',
            'ovtrequest_no' => 'Ovtrequest No',
            'ovtplanfrom' => 'Ovtplanfrom',
            'ovtplanto' => 'Ovtplanto',
            'ovtactfrom' => 'Ovtactfrom',
            'ovtactto' => 'Ovtactto',
            'attend_id' => 'Attend ID',
        ];
    }




}
