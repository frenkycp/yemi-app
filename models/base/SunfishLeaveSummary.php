<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "dbo.VIEW_EMPGETLEAVEYEMI".
 *
 * @property string $emp_no
 * @property string $leave_code
 * @property string $leavename_en
 * @property string $startvaliddate
 * @property string $endvaliddate
 * @property string $nextvaliddate
 * @property string $entitlement
 * @property string $proportional
 * @property string $bringforward
 * @property string $forfeited
 * @property string $adjustment
 * @property string $used
 * @property string $remaining
 * @property integer $active_status
 * @property string $aliasModel
 */
abstract class SunfishLeaveSummary extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbo.VIEW_EMPGETLEAVEYEMI';
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
            [['emp_no', 'leave_code', 'startvaliddate', 'active_status'], 'required'],
            [['startvaliddate', 'endvaliddate', 'nextvaliddate'], 'safe'],
            [['entitlement', 'proportional', 'bringforward', 'forfeited', 'adjustment', 'used', 'remaining'], 'number'],
            [['active_status'], 'integer'],
            [['emp_no', 'leave_code'], 'string', 'max' => 50],
            [['leavename_en'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'emp_no' => 'Emp No',
            'leave_code' => 'Leave Code',
            'leavename_en' => 'Leavename En',
            'startvaliddate' => 'Startvaliddate',
            'endvaliddate' => 'Endvaliddate',
            'nextvaliddate' => 'Nextvaliddate',
            'entitlement' => 'Entitlement',
            'proportional' => 'Proportional',
            'bringforward' => 'Bringforward',
            'forfeited' => 'Forfeited',
            'adjustment' => 'Adjustment',
            'used' => 'Used',
            'remaining' => 'Remaining',
            'active_status' => 'Active Status',
        ];
    }




}
